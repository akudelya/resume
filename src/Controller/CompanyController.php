<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CompanyController extends AbstractController
{
    #[Route('/companies', name: 'company_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Company::class);
        $companies = $repository->findAll();
        return $this->render('companies.html.twig', ['companies' => $companies]);
    }

    #[Route('/company/new', name: 'company_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($company);
            $entityManager->flush();
            return $this->redirectToRoute('company_list');
        }
        return $this->render('company.html.twig', ['form' => $form, 'form_title' => "New Company"]);
    }
    
    #[Route('/company/edit/{id}', name: 'company_edit')]
    public function update(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $company = $entityManager->getRepository(Company::class)->find($id);
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($company);
            $entityManager->flush();
            return $this->redirectToRoute('company_list');
        }
        return $this->render('company.html.twig', ['form' => $form, 'form_title' => "Edit Company"]);
    }

    #[Route('/company/delete/{id}', name: 'company_delete')]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $company = $entityManager->getRepository(Company::class)->find($id);
        $entityManager->remove($company);
        $entityManager->flush();
        return $this->redirectToRoute('company_list');
    }
}