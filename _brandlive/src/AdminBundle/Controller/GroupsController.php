<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\{Request,Response};

use AdminBundle\Entity\Groups;
use AdminBundle\Form\GroupsType;

/**
 * @Route("/admin/groups")
 */
class GroupsController extends Controller
{
    /**
     * @Route("/list", name="groups_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AdminBundle:Groups');
        $groups = $repo->findAll();
        return $this->render('@admin_views/Groups/list.html.twig', [
            "groups" => $groups
        ]);
    }
    
    /**
     * @Route("/new", name="groups_new")
     */
    public function new(Request $request)
    {
        $group = new Groups();
        $form = $this->createForm(GroupsType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();
            $this->addFlash('success', 'Item Agregado!');

            return $this->redirectToRoute('groups_list');
        }

        return $this->render('@admin_views/Groups/new.html.twig', [
            'group' => $group,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/edit/{id}", name="groups_edit")
     */
    public function edit(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AdminBundle:Groups');
        $group = $repo->findOneBy(["id" => $id]);

        $form = $this->createForm(GroupsType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Item Actualizado!');

            return $this->redirectToRoute('groups_list');
        }


        return $this->render('@admin_views/Groups/edit.html.twig', [
            'group' => $group,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/delete/{id}", name="groups_delete")
     */
    public function delete(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AdminBundle:Groups');
        $group = $repo->findOneBy(["id" => $id]);

        if ($this->isCsrfTokenValid('delete'.$group->getId(), $request->request->get('_token'))) {
            $em->remove($group);
            $em->flush();
            $this->addFlash('success', 'Item Eliminado!');
        }

        return $this->redirectToRoute('groups_list');
    }
}
