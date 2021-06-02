<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function list(TaskRepository $taskRepository): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $tasks = $taskRepository->findForAdmin($this->getUser());
        } else {
            $tasks = $taskRepository->findBy(['user' => $this->getUser()]);
        }

        return $this->render('task/list.html.twig', [
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $task = new Task();
        $task->setUser($this->getUser());
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function edit(Task $task, Request $request, EntityManagerInterface $em): Response
    {
        if ($task->getUser() !== $this->getUser()) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTask(Task $task, EntityManagerInterface $em): Response
    {
        if ($task->getUser() !== $this->getUser()) {
            throw $this->createNotFoundException();
        }

        $task->toggle(!$task->isDone());
        $em->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTask(Task $task, EntityManagerInterface $em): Response
    {
        if ($task->getUser() !== $this->getUser()) {
            throw $this->createNotFoundException();
        }

        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
