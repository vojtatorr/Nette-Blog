<?php

declare(strict_types=1);

namespace App\Presentation\Home;

use Nette;
use App\Model\PostManager;

final class HomePresenter extends BasePresenter
{
    public function __construct(
        private PostManager $postManager,
    ) { }

    public function renderDefault() 
    {
        $this->template->posts = $this->postManager->getPublicPosts(5);
    }
}       


