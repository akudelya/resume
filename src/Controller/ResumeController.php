<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Resume;
use App\Entity\ResumeToCompany;
use App\Form\ResumeType;
use App\Form\ResumeRateType;
use App\Form\ResumeSendType;
use \DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ResumeController extends AbstractController
{
    #[Route('/resumes', name: 'resume_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Resume::class);
        $resumes = $repository->findAll();
        return $this->render('resumes.html.twig', ['resumes' => $resumes]);
    }

    #[Route('/resume/new', name: 'resume_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $resume = new Resume();
        $form = $this->createForm(ResumeType::class, $resume);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $resume->setCreatedAt(new DateTimeImmutable());
            $resume->setModifiedAt(new DateTimeImmutable());
            $this->processDescription($form, $resume);
            $entityManager->persist($resume);
            $entityManager->flush();
            return $this->redirectToRoute('resume_list');
        }
        return $this->render('resume.html.twig', ['form' => $form, 'form_title' => "New Resume"]);
    }
    
    #[Route('/resume/edit/{id}', name: 'resume_edit')]
    public function update(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $resume = $entityManager->getRepository(Resume::class)->find($id);
        $form = $this->createForm(ResumeType::class, $resume);
        if ($resume->getDescriptionType() == 'file') {
            $form->get('description')->setData('');
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $resume->setModifiedAt(new DateTimeImmutable());
            $this->processDescription($form, $resume);
            $entityManager->persist($resume);
            $entityManager->flush();
            return $this->redirectToRoute('resume_list');
        }
        return $this->render('resume.html.twig', ['form' => $form, 'form_title' => "Edit resume"]);
    }

    #[Route('/resume/delete/{id}', name: 'resume_delete')]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $resume = $entityManager->getRepository(Resume::class)->find($id);
        $entityManager->remove($resume);
        $entityManager->flush();
        return $this->redirectToRoute('resume_list');
    }
    
    #[Route('/resume/send/{id}', name: 'resume_send')]
    public function send(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $resume = $entityManager->getRepository(Resume::class)->find($id);
        $form = $this->createForm(ResumeSendType::class, $resume);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $company = $form->get('company')->getData();
            $resumeToCompany = new ResumeToCompany();
            $resumeToCompany->setCompany($company);
            $resumeToCompany->setResume($resume);
            $resume->sendToCompany($resumeToCompany);
            $entityManager->persist($resumeToCompany);
            $entityManager->flush();
            return $this->redirectToRoute('resume_list');
        }
        $sentToCompanies = $resume->getSentToCompanies();
        return $this->render('resume_send.html.twig', [
            'form' => $form,
            'resume' => $resume,
            'form_title' => "Send resume",
            'sentToCompanies' => $sentToCompanies,
        ]);
    }

    #[Route('/resume/rate/{id}/{companyid}', name: 'resume_rate')]
    public function rate(Request $request, EntityManagerInterface $entityManager, int $id, int $companyid): Response
    {
        $resume = $entityManager->getRepository(Resume::class)->find($id);
        $company = $entityManager->getRepository(Company::class)->find($companyid);
        $resumeToCompany = $entityManager->getRepository(ResumeToCompany::class)->findOneBy(['resume' => $resume, 'company' => $company]);
        $form = $this->createForm(ResumeRateType::class, $resumeToCompany);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('resume_send', ['id' => $id]);
        }
        return $this->render('resume_rate.html.twig', [
            'form' => $form,
            'resume' => $resume,
            'resumeToCompany' => $resumeToCompany,
            'form_title' => "Rate resume",
        ]);
    }

    private function processDescription($form, Resume $resume): void
    {
        $file = $form->get('description_file')->getData();
        $text = $form->get('description')->getData();
        if (!empty($file)) {
            $resume->setDescriptionType('file');
            $resume->setDescription(serialize([
                'filename' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'content' => $file->getContent(),
            ]));
        }
        else {
            $resume->setDescriptionType('text');
            $resume->setDescription($text);
        }
    }
}