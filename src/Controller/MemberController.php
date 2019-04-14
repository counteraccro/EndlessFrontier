<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Member;
use App\Form\MemberType;

class MemberController extends AbstractController
{

    /**
     *
     * @Route("/member", name="member_index")
     */
    public function index()
    {
        $memberRepository = $this->getDoctrine()->getRepository(Member::class);
        $members = $memberRepository->findAll();
        
        return $this->render('member/index.html.twig', [
            'members' => $members
        ]);
    }

    /**
     * Permet d'ajouter un nouveau membre
     * @Route("/member/add", name="member_add")
     * @param Request $request
     */
    public function addMember(Request $request)
    {
        $member = new Member();

        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                
                $em->persist($member);
                $em->flush();
                
                $this->addFlash('success', 'le membre ' . $member->getName() . ' à correctement été ajouté');
                
                return $this->redirectToRoute('member_index');
            }
        }
        
        return $this->render('member/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    /**
     * Permet d'éditer un nouveau membre
     * @Route("/member/edit/{id}", name="member_edit")
     * @ParamConverter("member", options={"mapping": {"id": "id"}})
     * @param Request $request
     * @param Member $member
     */
    public function editMember(Request $request, Member $member)
    {
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                
                $em->persist($member);
                $em->flush();
                
                $this->addFlash('success', 'le membre ' . $member->getName() . ' à correctement été modifié');
                
                return $this->redirectToRoute('member_index');
            }
        }
        
        return $this->render('member/edit.html.twig', [
            'form' => $form->createView(),
            'member' => $member
        ]);
    }
    
    /**
     * Supprime un membre
     *
     * @Route("/member/delete/{id}", name="member_delete")
     * @ParamConverter("member", options={"mapping": {"id": "id"}})
     *
     * @param Member $member
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteMember(Member $member)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($member);
        $entityManager->flush();
        
        $this->addFlash('success', 'le membre ' . $member->getName() . ' à correctement été supprimé');
        
        return $this->redirectToRoute('member_index');
    }
    
    /**
     * Active ou désactive un membre
     *
     * @Route("/member/disabled/{id}", name="member_disabled")
     * @ParamConverter("member", options={"mapping": {"id": "id"}})
     *
     * @param Member $member
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disabledMember(Member $member)
    {
        $str = '';
        if($member->getDisabled() == 0)
        {
            $member->setDisabled(1);
            $str = 'bannis';
        }
        else
        {
            $member->setDisabled(0);
            $str = 'actif';
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($member);
        $entityManager->flush();
        
        $this->addFlash('success', 'le membre ' . $member->getName() . ' est maintenant ' . $str);
        
        return $this->redirectToRoute('member_index');
    }
}
