<?php

declare(strict_types=1);

namespace App\Components\User\Sign\In;

use Nette\Application\UI\Control as NetteControl;
use Nette\Application\UI\Form;

class Control extends NetteControl
{

    /**
     * @var callable
     */
    private $onSuccess;

    public function __construct(
        private FormFactory $formFactory,
        callable $onSuccess,
    ){
        $this->onSuccess = $onSuccess;
     }

    public function render(): void
    {
        $this->template->render(__DIR__ . "\default.latte");
    }

    public function createComponentForm(): Form
	{
		$form = $this->FormFactory->create();

		$form->onSuccess[] = $this->onSuccess;

		return $form;
	}
}