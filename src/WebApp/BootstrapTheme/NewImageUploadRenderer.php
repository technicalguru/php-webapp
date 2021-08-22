<?php

namespace WebApp\BootstrapTheme;

use WebApp\Utils;

class NewImageUploadRenderer extends \WebApp\DefaultTheme\DivRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('cropper');
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
			$rc .= '<div class="cropper-nav" style="height: 150px; margin: 10px; overflow-x: auto;white-space: nowrap;">';
			foreach ($this->component->getImages() AS $id => $uri) {
				$rc .= '<a data-imgid="'.$id.'" href="#" onclick="cropperUI.selectImage(this); return false;"><img class="img-fluid img-thumbnail" style="margin:10px; max-height: 80%;" src="'.$uriDir.'/'.$uri.'"></a>';
			}

			// Always create the new image upload here
			$class = ($this->component->getImageCount() < $this->component->getMaxImages()) ? '' : 'hidden';
			$rc .= '<a data-imgid="newImg" href="#" onclick="cropperUI.addImage(this); return false;"><img class="img-fluid img-thumbnail" style="margin:10px; max-height: 80%;" src="'.\WebApp\Utils::getImageBasePath(TRUE).'/multi-image-upload-new.png"></a>';
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
		$rc  = '<div class="cropper-editor" style="max-width: 400px; max-height: 400px; margin: 20px;">'.
		          '<img data-imgid="'.$did.'" class="cropper-image" style="background-image: url(\'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQAQMAAAAlPW0iAAAAA3NCSVQICAjb4U/gAAAABlBMVEXMzMz////TjRV2AAAACXBIWXMAAArrAAAK6wGCiw1aAAAAHHRFWHRTb2Z0d2FyZQBBZG9iZSBGaXJld29ya3MgQ1M26LyyjAAAABFJREFUCJlj+M/AgBVhF/0PAH6/D/HkDxOGAAAAAElFTkSuQmCC\'); width: 400px; height: 400px;" src="'.$src.'">'.
		          $this->renderActions().
		          //$this->renderDocToggles().
		       '</div>';
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
				  $this->renderActionButton('cropperUI.setDragMode(this,\'move\');', 'Move', 'Move Help', 'fa fa-arrows-alt').
				  $this->renderActionButton('cropperUI.setDragMode(this,\'crop\');', 'Crop', 'Crop Help', 'fa fa-crop-alt').
				'</div>'.
				// No move into directions (yet)!
				// Rotate
				'<div class="btn-group">'.
				  $this->renderActionButton('cropperUI.rotate(this,-90);', 'Rotate Left', 'Rotate Help', 'fa fa-undo-alt').
				  $this->renderActionButton('cropperUI.rotate(this,90);', 'Rotate Right', 'Rotate Help', 'fa fa-redo-alt').
				'</div>'.
				// Flip
				'<div class="btn-group">'.
				  $this->renderActionButton('cropperUI.scaleX(this,-1);', 'Flip Horizontally', 'Flip Help', 'fa fa-arrows-alt-h').
				  $this->renderActionButton('cropperUI.scaleY(this,-1);', 'Flip Vertically', 'Flip Help', 'fa fa-arrows-alt-v').
				'</div>'.
				// Finish / Cancel
				'<div class="btn-group">'.
				  '<label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">'.
				    '<input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">'.
				    '<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="Import image">'.
				      '<span class="fa fa-upload"></span>'.
				    '</span>'.
				  '</label>'.
				  $this->renderActionButton('cropperUI.save(this);', 'Save', 'Save Help', 'fa fa-save').
				  $this->renderActionButton('cropperUI.reset(this);', 'Clear Changes', 'Clear Help', 'fa fa-trash-restore-alt').
				'</div>'.
				// Delete
				'<div class="btn-group">'.
				  $this->renderActionButton('cropperUI.destroy(this);', 'Delete', 'Delete Help', 'fa fa-trash-alt', 'danger').
				'</div>'.
		      '</div>';
		return $rc;
	}

	public function renderActionButton($click, $title, $help, $icon, $type = 'primary') {
		$rc = '<button type="button" class="btn btn-'.$type.'" onClick="'.$click.'" title="'.htmlentities($title).'">'.
		         '<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="'.htmlentities($help).'">'.
		            '<span class="'.$icon.'"></span>'.
		         '</span>'.
		      '</button>';
		return $rc;
	}

	public function renderDocToggles() {
		return '';
	}
}

