<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\nette-blog\app\Presentation\Post/show.latte */
final class Template_d857640e26 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\nette-blog\\app\\Presentation\\Post/show.latte';

	public const Blocks = [
		['content' => 'blockContent', 'title' => 'blockTitle'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		$this->renderBlock('content', get_defined_vars()) /* line 1 */;
	}


	/** {block content} on line 1 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '
<p><a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Home:default')) /* line 3 */;
		echo '">← zpět na výpis příspěvků</a></p>

<div class="date">';
		echo LR\Filters::escapeHtmlText(($this->filters->date)($post->created_at, 'F j, Y')) /* line 5 */;
		echo '</div>

';
		$this->renderBlock('title', get_defined_vars()) /* line 7 */;
		echo '
<div class="post">';
		echo LR\Filters::escapeHtmlText($post->content) /* line 9 */;
		echo '</div>';
	}


	/** n:block="title" on line 7 */
	public function blockTitle(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h1>';
		echo LR\Filters::escapeHtmlText($post->title) /* line 7 */;
		echo '</h1>
';
	}
}
