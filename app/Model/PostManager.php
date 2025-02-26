<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Application\LinkGenerator;
use Nette\Application\UI\TemplateFactory;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Nette\SmartObject;
use Nette\Utils\DateTime;
use Tracy\Debugger;

class PostManager extends BaseManager
{
    use SmartObject;

    public function __construct(
        Explorer $db,
        private TemplateFactory $templateFactory,
        private LinkGenerator $linkGenerator,
    ) { 
        parent::__construct($db);
    }

    public function getTableName(): string
    {
        return "post";
    }

    public function insert(array $values): ActiveRow 
    {
        $retVal = parent::insert($values);

        // Mail sent START

        if (Debugger::$productionMode){
            $latte = $this->templateFactory->createTemplate();
            $latte->getLatte()->addProvider("uiControl", $this->linkGenerator);

            $message = new Message();
            $message->setFrom("JohnDoe@gmail.com");
            $message->addTo("default@news.cz");
    
            $message->setHtmlBody($latte->renderToString(__DIR__ . "/addPostMail.latte", $retVal->toArray()));
    
            $sender = new SendmailMailer();
            $sender->send($message);
        }

        //Mail send END


    }

    public function getPublicPosts(int $limit = null): Selection
    {
        return $this->getAll()
            ->where('created_at < ', new DateTime)
            ->order('created_at DESC')
            ->limit($limit);
    }
}