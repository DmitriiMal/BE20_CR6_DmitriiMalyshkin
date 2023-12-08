<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Events;
use App\Form\EventsType;
use Doctrine\ORM\EntityManagerInterface;

class EventsController extends AbstractController
{
    #[Route('/', name: 'app_events')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $events = $doctrine->getRepository(Events::class)->findAll();

        return $this->render('events/index.html.twig', [
            'events' => $events
        ]);
    }


    #[Route('/create', name: 'app_create')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $event = new Events();
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($event);
            $em->flush();

            $this->addFlash(
                'notice',
                'Event Added'
            );
            return $this->redirectToRoute('app_events');
        }

        return $this->render('events/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/edit{id}', name: 'app_edit')]
    public function edit(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $event = $doctrine->getRepository(Events::class)->find($id);
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($event);
            $em->flush();
            $this->addFlash(
                'notice',
                'Event has been edited'
            );

            return $this->redirectToRoute('app_events');
        }

        return $this->render('events/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/{id}', name: 'app_details')]
    public function details(ManagerRegistry $doctrine, $id): Response
    {
        $event = $doctrine->getRepository(Events::class)->find($id);
        return $this->render('events/details.html.twig', [
            'event' => $event
        ]);
    }




    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete(Request $request, Events $event, EntityManagerInterface $entityManager, $id): Response
    {

        $event->getId();
        $entityManager->remove($event);
        $entityManager->flush();

        // $em = $this->getDoctrine()->getManager();
        // $event = $em->getRepository('App:event')->find($id);
        // $em->remove($event);
        // $em->flush();

        $this->addFlash(
            'notice',
            'Event has been removed'
        );

        return $this->redirectToRoute('app_events');
    }
}
