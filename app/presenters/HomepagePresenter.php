<?php

namespace App\Presenters;

use App\Components\ExampleFormWithFactory;
use App\Components\IExampleFormFactory;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;

class HomepagePresenter extends Presenter
{
	/** @var IExampleFormFactory @inject */
	public $exampleFormFactory;

	/** @var ExampleFormWithFactory @inject */
	public $exampleFormWithFactory;

	/**
	 * @return Form
	 */
	public function createComponentForm1()
	{
		$form = $this->exampleFormFactory->create();
		$form;
		return $form;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm2()
	{
		$form = $this->exampleFormWithFactory->create();
		$form;
		return $form;
	}
}
