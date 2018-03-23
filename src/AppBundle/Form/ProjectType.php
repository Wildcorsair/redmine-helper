<?php
/**
 * Created by PhpStorm.
 * User: texas
 * Date: 3/21/18
 * Time: 8:55 PM
 */

namespace AppBundle\Form;


use AppBundle\Service\RedmineRequestService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ProjectType extends AbstractType
{
    private $redmineRequestService;

    /**
     * ProjectType constructor.
     *
     * @param RedmineRequestService $redmineRequestService
     */
    public function __construct(RedmineRequestService $redmineRequestService)
    {
        $this->redmineRequestService = $redmineRequestService;
    }

    /**
     * Builds Projects drop-down list.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $projectsData = $this->redmineRequestService->getProjectsArray();

        if (!$projectsData) {
            $projectsData = ['No Projects' => 'empty'];
        }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($projectsData) {
            $form = $event->getForm();

            $formOptions = [
                'attr' => ['class' => 'projects-list'],
                'choices' => $projectsData
            ];

            $form->add('projects', ChoiceType::class, $formOptions);
        });
    }
}