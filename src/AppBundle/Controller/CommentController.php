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
     * Displays all comments by project.
     *
     * @Route("/dashboard/projects/{projectId}/comments", requirements={"projectId" = "\d+"}, name="comments");
     */
    public function indexAction($projectId)
    {
        $comments = $this->getDoctrine()->getRepository(Comment::class)->getAllComments($projectId);
        return $this->render('dashboard/comments/index.html.twig', [
            'comments' => $comments,
            'project_id' => $projectId
        ]);
    }

    /**
     * Create new comment action.
     *
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

            if (!empty($commentId) && $commentId > 0) {
                $this->addFlash('success', 'The Comment was successfully updated.');
            } else {
                $this->addFlash('error', 'Ooops, something went wrong.');
            }

            return $this->redirectToRoute('comment_edit', ['projectId' => $projectId, 'commentId' => $commentId]);
        }

        return $this->render('dashboard/comments/create.html.twig', [
            'comment'    => $commentForm->createView(),
            'project_id' => $projectId
        ]);
    }

    /**
     * Comment edit action.
     *
     * @Route("/dashboard/projects/{projectId}/comments/edit/{commentId}", requirements={"projectId" = "\d+", "commentId" = "\d+"}, name="comment_edit")
     */
    public function editAction(Request $request, $projectId, $commentId)
    {
        $user = $this->getUser();
        $comment = $this->getDoctrine()->getRepository(Comment::class)->find($commentId);

        $commentForm = $this->createForm(CommentType::class, [
            'project_id' => $projectId,
            'user' => $user,
            'comment' => $comment
        ]);

        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $commentFormData = $commentForm->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $comment->setContent($commentFormData['content']);
            $comment->setUpdatedAt(new \DateTime());

            $entityManager->persist($comment);
            $entityManager->flush();

            $commentId = $comment->getId();

            if (!empty($commentId) && $commentId > 0) {
                $this->addFlash('success', 'The Comment was successfully updated.');
            } else {
                $this->addFlash('error', 'Ooops, something went wrong.');
            }

            return $this->redirectToRoute('comment_edit', ['projectId' => $projectId, 'commentId' => $commentId]);
        }

        return $this->render('dashboard/comments/edit.html.twig', [
            'comment' => $commentForm->createView(),
            'project_id' => $projectId
        ]);
    }
}
