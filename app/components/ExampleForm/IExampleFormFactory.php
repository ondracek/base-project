<?php

namespace App\Components;

interface IExampleFormFactory
{
	/**
	 * @return ExampleForm
	 */
	public function create();
}