<?php

declare(strict_types=1);

namespace App\Presentation\Home;

use Nette;
use Nette\Database\Explorer;
use Nettey\Application\UI\Presenter;

final class HomePresenter extends Nette\Application\UI\Presenter
{
    
    public function __construct(
        private Explorer $db,
    ) { }

    public function renderDefault() {
        $this->template->posts = $this->db->table("post")
            ->order('created_at DESC')
            ->limit(5)
            ->fetchAll();  // Make sure to fetch all posts as an array
    }
}       


