<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    /**
     * @Route("/dashboard/comments", name="comments");
     */
    public function indexAction()
    {
        return $this->render('dashboard/comments/index.html.twig');
    }

    /**
     * @Route("/dashboard/projects/{projectId}/comments/create", requirements={"projectId" = "\d+"}, name="comment_create");
     */
    public function createAction(Request $request, $projectId)
    {
        $user = $this->getUser();
        $commentForm = $this->createForm(CommentType::class, ['project_id' => $projectId, 'user' => $user]);

        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $commentFormData = $commentForm->getData();

            $comment = new Comment();
            $entityManager = $this->getDoctrine()->getManager();

            $comment->setAuthor($commentFormData['author']);
            $comment->setProjectId($commentFormData['project_id']);
            $comment->setContent($commentFormData['content']);
            $comment->setCreatedAt(new \DateTime());

            $entityManager->persist($comment);
            $entityManager->flush();

            $commentId = $comment->getId();

            $this->addFlash('success', 'The new Comment was successfully saved.');

            return $this->redirectToRoute('comment_edit', ['projectId' => $projectId, 'commentId' => $commentId]);
        }

        return $this->render('dashboard/comments/create.html.twig', [
            'comment'    => $commentForm->createView(),
            'project_id' => $projectId
        ]);
    }

    /**
     * @Route("/dashboard/projects/{projectId}/comments/edit/{commentId}", requirements={"projectId" = "\d+", "commentId" = "\d+"}, name="comment_edit")
     */
    public function editAction($projectId, $commentId)
    {
        $user = $this->getUser();
        $comment = $this->getDoctrine()->getRepository(Comment::class)->find($commentId);

        $commentForm = $this->createForm(CommentType::class, [
            'project_id' => $projectId,
            'user' => $user,
            'comment' => $comment
        ]);

        return $this->render('dashboard/comments/edit.html.twig', [
            'comment' => $commentForm->createView(),
            'project_id' => $projectId
        ]);
    }
}
