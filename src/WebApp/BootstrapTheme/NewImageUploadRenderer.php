<?php

namespace WebApp\BootstrapTheme;

use TgI18n\I18N;
use WebApp\Utils;

class NewImageUploadRenderer extends \WebApp\DefaultTheme\DivRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('cropper')
			->setData('width', $component->getWidth())
			->setData('height', $component->getHeight())
			->setData('aspect-ratio', $component->getAspectRatio());
		$this->theme->addFeature(\WebApp\BootstrapTheme\BootstrapTheme::CROPPERJS);
	}

	public function renderChildren() {
		$rc  = $this->renderNavigation();
		$rc .= $this->renderEditor();
		return $rc;
	}

	public function renderNavigation() {
		$rc     = '';
		$uriDir = $this->component->getUriDir();
		if ($this->component->hasNavigation()) {
			$rc .= '<div class="cropper-nav" data-maximages="'.$this->component->getMaxImages().'">';
			foreach ($this->component->getImages() AS $id => $uri) {
				$rc .= '<a class="cropper-nav-link" data-imgid="'.$id.'" href="#" onclick="cropperUI.selectImage(this, true); return false;"><img class="img-fluid img-thumbnail" src="'.$uriDir.'/'.$uri.'"></a>';
			}

			// Always create the new image upload here
			$style = ($this->component->getImageCount() < $this->component->getMaxImages()) ? '' : ' style="display:none;"';
			$rc .= '<a '.$style.' data-imgid="newImg" href="#" onclick="cropperUI.addImage(this, true); return false;"><img class="img-fluid img-thumbnail" src="'.\WebApp\Utils::getImageBasePath(TRUE).'/multi-image-upload-new.png"></a>';
			$rc .= '</div>';
		}
		return $rc;
	}

	public function renderEditor() {
		foreach ($this->component->getImages() AS $id => $uri) {
			$src = $this->component->getUriDir().'/'.$uri;
			$did = $id;
			break;
		}
		$width  = $this->component->getWidth();
		$height = $this->component->getHeight();
		$rc  = '<div class="cropper-editor">'.
		          '<img data-imgid="'.$did.'" class="cropper-image img-fluid" src="'.$src.'">'.
		          //$this->renderDocToggles().
		       '</div>'.
		       $this->renderActions();
		return $rc;
	}

	public function renderActions() {
		$rc = '<div class="cropper-actions docs-buttons">'.
				// Zoom
//				'<div class="btn-group">'.
//				  $this->renderActionButton('zoom', '0.1', 'Zoom In', 'Zoom Help', 'fa fa-search-plus').
//				  $this->renderActionButton('zoom', '-0.1', 'Zoom Out', 'Zoom Help', 'fa fa-search-minus').
//				'</div>'.
				// Mouse Mode
				'<div class="btn-group">'.
				  $this->renderActionButton('cropperUI.setDragMode(this,\'move\');', 'move', 'fa fa-arrows-alt').
				  $this->renderActionButton('cropperUI.setDragMode(this,\'crop\');', 'crop', 'fa fa-crop-alt').
				'</div>'.
				// No move into directions (yet)!
				// Rotate
				'<div class="btn-group">'.
				  $this->renderActionButton('cropperUI.rotate(this,-90);', 'rotate_left',  'fa fa-undo-alt').
				  $this->renderActionButton('cropperUI.rotate(this,90);',  'rotate_right', 'fa fa-redo-alt').
				'</div>'.
				// Flip
				'<div class="btn-group">'.
				  $this->renderActionButton('cropperUI.scaleX(this,-1);', 'flip_horizontally', 'fa fa-arrows-alt-h').
				  $this->renderActionButton('cropperUI.scaleY(this,-1);', 'flip_vertically',   'fa fa-arrows-alt-v').
				'</div>'.
				// Finish / Cancel
				'<div class="btn-group">'.
				  '<label class="btn btn-primary btn-upload" for="inputImage" title="'.htmlentities(I18N::_('upload_import_help')).'">'.
				    '<input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">'.
				    '<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="'.htmlentities(I18N::_('upload_import_help')).'">'.
				      '<span class="fa fa-upload"></span>'.
				    '</span>'.
				  '</label>'.
				  $this->renderActionButton('cropperUI.reset(this);', 'reset', 'fa fa-trash-restore-alt').
				'</div>'.
				// Delete
				'<div class="btn-group">'.
				  $this->renderActionButton('cropperUI.delete(this);', 'delete', 'fa fa-trash-alt', 'danger').
				'</div>'.
				'<div class="btn-group">'.
				//  $this->renderActionButton('cropperUI.info(this);', 'Info', 'fa fa-info', 'secondary').
				  $this->renderActionButton('cropperUI.save(this);', 'save', 'fa fa-save', 'success').
				'</div>'.
		      '</div>';
		return $rc;
	}

	public function renderActionButton($click, $title, $icon, $type = 'primary') {
		$rc = '<button type="button" class="btn btn-'.$type.'" onClick="'.$click.'" title="'.htmlentities(I18N::_('upload_'.$title.'_help')).'">'.
		         '<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="'.htmlentities(I18N::_('upload_'.$title.'_help')).'">'.
		            '<span class="'.$icon.'"></span>'.
		         '</span>'.
		      '</button>';
		return $rc;
	}

	public function renderDocToggles() {
		return '';
	}
}

