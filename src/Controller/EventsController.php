<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Events;
use App\Entity\Type;
use App\Form\EventsType;
use Doctrine\ORM\EntityManagerInterface;


class EventsController extends AbstractController
{
    #[Route('/', name: 'app_events')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {

        $type = $request->query->get('fk_type', 'all');

        $entityManager = $doctrine->getManager();

        // $allEvents = $doctrine->getRepository(Events::class)->findAll();
        $allEvents = $doctrine->getRepository(Type::class)->findAll();


        // dd($allEvents);
        if ($type !== 'all') {
            $events = $entityManager
                ->getRepository(Events::class)
                ->createQueryBuilder('e')
                ->join('e.fk_type', 't')
                ->andWhere('t.name = :type')
                ->setParameter('type', $type)
                ->getQuery()
                ->getResult();
        } else {
            $events = $doctrine->getRepository(Events::class)->findAll();
        }

        return $this->render('events/index.html.twig', [
            'events' => $events,
            'allEvents' => $allEvents,
            'type' => $type,
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


    #[Route('/edit/{id}', name: 'app_edit')]
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


    #[Route('/details/{id}', name: 'app_details')]
    // public function details(ManagerRegistry $doctrine, $id): Response
    public function details(Events $event): Response
    {
        // $event = $doctrine->getRepository(Events::class)->find($id);
        return $this->render('events/details.html.twig', [
            'event' => $event,
            'type' => $event->getFkType(),
            'manager' => $event->getFkManager()
        ]);
    }




    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete(Request $request, Events $event, EntityManagerInterface $entityManager, $id): Response
    {

        $event->getId();
        $entityManager->remove($event);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Event has been removed'
        );

        return $this->redirectToRoute('app_events');
    }
}
