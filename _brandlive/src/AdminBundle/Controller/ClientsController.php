<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\{Request,Response};

use AdminBundle\Entity\Clients;
use AdminBundle\Entity\ClientsGroups;
use AdminBundle\Repository\ClientsRepository;
use AdminBundle\Form\ClientsType;
use AdminBundle\Form\ClientsSearchBarType;

/**
 * @Route("/admin/clients")
 */
class ClientsController extends Controller
{
    /**
     * @Route("/list", name="clients_list")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AdminBundle:Clients');
        $clients = $repo->findAll();

        $form = $this->createForm(ClientsSearchBarType::class, []);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $formData = $request->request->get('clients_search_bar');
            $clients = $repo->findClients($formData);
            /* dump($request->request,$clients);
            die(); */
        }

        return $this->render('@admin_views/Clients/list.html.twig', [
            "clients" => $clients,
            "form" => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/new", name="clients_new")
     */
    public function new(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $client = new Clients();
        $form = $this->createForm(ClientsType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $listGroupsSelected = array_key_exists("groups",$request->request->get('clients'))? $request->request->get('clients')["groups"]: [];
            
            $em->persist($client);
            $em->flush();
            if(count($listGroupsSelected) > 0 ){
                foreach ($listGroupsSelected as $groupId) {
                    $clientsGroups = New ClientsGroups();
                    $clientsGroups->setClients($client);
                    $group = $em->getRepository("AdminBundle:Groups")->find($groupId);
                    $clientsGroups->setGroups($group);
                    $em->persist($clientsGroups);
                    $em->flush();
                }
            }
            
            $this->addFlash('success', 'Item Añadido!');

            return $this->redirectToRoute('clients_list');
        }

        return $this->render('@admin_views/Clients/new.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/edit/{id}", name="clients_edit")
     */
    public function edit(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AdminBundle:Clients');
        $clients = $repo->findOneBy(["id" => $id]);

        /* usersProjects DB */
        $listClientsGroups = [];
        $clientsGroups = $em->getRepository("AdminBundle:ClientsGroups")->findBy([ "clients" => $clients]);
        if (isset($clientsGroups)) {
            foreach($clientsGroups as $clientGroup) {
                $item["id"] = $clientGroup->getGroups()->getId();
                $item["name"] = $clientGroup->getGroups()->getName();
                array_push($listClientsGroups,$item);	
            }
        }
        

        $form = $this->createForm(ClientsType::class, $clients);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = $em->getRepository("AdminBundle:Clients")->findOneBy([ "id" => $id]);
			$listGroupSelected = array_key_exists("groups",$request->request->get('clients'))? $request->request->get('clients')["groups"]: [];
            
            /* REMOVE Items ClientsGroups */
            foreach ($listClientsGroups as $group) {
                $remove = true;
                foreach ($listGroupSelected as $groupId) {
                    if($group["id"] == $groupId){ $remove = false; }
                }

                if ($remove) {
                    $groups = $em->getRepository("AdminBundle:Groups")->find($group["id"]);
                    $ClientsGroups = $em->getRepository("AdminBundle:ClientsGroups")->findOneBy([
                        "clients" => $client,
                        "groups" => $groups
                    ]);
                    $em->remove($ClientsGroups);
                    $em->flush(); 
                }
            }
            
            
            /* ADD Items ClientsGroups */
            if(count($listGroupSelected) > 0 ){
                foreach ($listGroupSelected as $groupId) {
                    $add = true;
                    foreach ($listClientsGroups as $group) {
                        if($group["id"] == $groupId){ $add = false; }
                    }
                    if ($add) {
                        $clientsGroups = New ClientsGroups();
                        $clientsGroups->setClients($client);
                        $group = $em->getRepository("AdminBundle:Groups")->find($groupId);
                        $clientsGroups->setGroups($group);
                        $em->persist($clientsGroups);
                        $em->flush();
                    }
                }  
            }





            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Item Actualizado!');

            return $this->redirectToRoute('clients_list');
        }


        return $this->render('@admin_views/Clients/edit.html.twig', [
            'client' => $clients,
            'form' => $form->createView(),
            'listClientsGroups' => json_encode($listClientsGroups),
        ]);
    }
    
    /**
     * @Route("/delete/{id}", name="clients_delete")
     */
    public function delete(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AdminBundle:Clients');
        $client = $repo->findOneBy(["id" => $id]);

        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $em->remove($client);
            $em->flush();
            $this->addFlash('success', 'Item Eliminado!');
        }

        return $this->redirectToRoute('clients_list');
    }
}
