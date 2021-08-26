<?php

namespace WebApp\BootstrapTheme;

use TgI18n\I18N;

class ImageCarouselRenderer extends \WebApp\DefaultTheme\DivRenderer {

    public function __construct($theme, $component) {
        parent::__construct($theme, $component);
		$this->addClass('image-carousel');
	}

	public function renderChildren() {
		$rc = '';
		$images = $this->component->getImages();
		if (count($images) == 0) {
			// Placeholder image or nothing?
		} else if (count($images) == 1) {
			// No navigation - just a simple image
			$rc = $this->theme->renderComponent($images[0]->image);
		} else if (count($images) > 1) {
			$id    = $this->component->getId().'-carousel';

			// Navigation and carousel
			$nav   = '<ol class="carousel-indicators">';
			$inner = '<div class="carousel-inner">';
			$idx   = 0;
			foreach ($images AS $image) {
				$active = $idx == 0 ? 'active' : '';
				$nav   .= '<li data-target="#'.$id.'" data-slide-to="'.$idx.'" class="'.$active.'"></li>';
				$title  = htmlentities($image->image->getTitle());
				$inner .= '<div class="carousel-item '.$active.'">'.
				             '<img src="'.$image->image->getUrl().'" class="d-block w-100" alt="'.$title.'" title="'.$title.'">';
				if ($image->title || $image->description) {
					$inner .= '<div class="carousel-caption d-none d-md-block">';
					if ($image->title)       $inner .= '<h5>'.$image->title.'</h5>';
					if ($image->description) $inner .= '<p>'.$image->description.'</p>';
					$inner .= '</div>';
				}
				$inner .= '</div>';
				$idx++;
			}
			$inner .= '</div>';
			$nav   .= '</ol>';

			// Composite
			$rc   = '<div id="'.$id.'" class="carousel slide" data-ride="carousel" data-interval="false">'.$nav.$inner.
			           '<a class="carousel-control-prev" href="#'.$id.'" role="button" data-slide="prev">'.
			              '<span class="carousel-control-prev-icon" aria-hidden="true"></span>'.
			              '<span class="sr-only">'.I18N::_('previous').'</span>'.
			           '</a>'.
					   '<a class="carousel-control-next" href="#'.$id.'" role="button" data-slide="next">'.
					      '<span class="carousel-control-next-icon" aria-hidden="true"></span>'.
					      '<span class="sr-only">'.I18N::_('next').'</span>'.
					   '</a>'.
					'</div>';
		}
		return $rc;
	}
}

