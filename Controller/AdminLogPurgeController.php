<?php

namespace AdminLogPurge\Controller;

use AdminLogPurge\Event\AdminLogPurgeEvent;
use AdminLogPurge\Event\AdminLogPurgeEvents;
use AdminLogPurge\Form\AdminLogPurgeForm;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;
use \Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\HttpFoundation\Response;
use Thelia\Core\HttpFoundation\Session\Session;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Translation\Translator;

/**
 * Class AdminLogPurgeController
 * @package AdminLogPurge\Controller
 */
class AdminLogPurgeController extends BaseAdminController
{
    /**
     * @return mixed|Response
     */
    #[Route('/admin/module/AdminLogPurge', name: 'adminlogpurge.configuration')]
    public function viewConfigAction(): mixed
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'AdminLogPurge', AccessManager::VIEW)) {
            return $response;
        }

        return $this->render("adminlogpurge-configuration", []);
    }

    /**
     * Remove logs with last_update older than the given date
     *
     * @return mixed|RedirectResponse|Response
     */
    #[Route('/admin/module/AdminLogPurge/remove', name: 'adminlogpurge.remove')]
    public function removeAction(Session $session, EventDispatcherInterface $dispatcher): mixed
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'AdminLogPurge', AccessManager::DELETE)) {
            return $response;
        }

        $form = $this->createForm(AdminLogPurgeForm::getName());

        try {
            // Validate form
            $vForm = $this->validateForm($form, 'POST');

            // Build event from form data & dispatch it
            $event = new AdminLogPurgeEvent($vForm->getData()['start_date']);
            $dispatcher->dispatch($event, AdminLogPurgeEvents::REMOVE_ADMIN_LOG);

            // Get number of removed logs
            $session->getFlashBag()->add(
                'remove-logs-result',
                Translator::getInstance()->trans(
                    'Successfully removed %nbLogs logs!',
                    ['%nbLogs' => $event->getAdminLogs()],
                    'adminlogpurge'
                )
            );

            // Redirect
            return new RedirectResponse($form->getSuccessUrl());
        } catch (\Exception $e) {
            $this->setupFormErrorContext(
                'remove',
                $e->getMessage(),
                $form
            );

            return $this->render('adminlogpurge-configuration', []);
        }
    }
}