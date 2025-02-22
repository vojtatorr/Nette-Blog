<?php

declare(strict_types=1);

namespace App\Presentation\Home;

use Nette;
use App\Model\PostManager;  // Correct namespace
use Nette\Application\UI\Presenter;

final class HomePresenter extends Presenter
{
    public function __construct(
        private PostManager $postManager
    ) { }

    public function renderDefault() 
    {
        $this->template->posts = $this->postManager->getPublicPosts()
            ->limit(5);
    }
}       


