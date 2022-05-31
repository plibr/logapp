<?php
Yii::import('RestfullYii.actions.ERestBaseAction');
Yii::import('RestfullYii.filters.CustomFilter');
Yii::import('RestfullYii.models.CustomLog');
Yii::import('RestfullYii.filters.CustomGroupBy');
/**
 * Action For Rest Gets
 *
 * Provides the action for rest get behavior
 *
 * @category   PHP
 * @package    Starship
 * @subpackage Restfullyii/actions
 * @copyright  Copyright (c) 2013 Evan Frohlich (https://github.com/evan108108)
 * @license    https://github.com/evan108108   OSS
 * @version    Release: 1.2.0
 */
class EActionRestGET extends ERestBaseAction
{
	/**
	 * run
	 *
	 * Called by Yii for GET verb
	 * 
	 * @param (Mixed/Int) (id) unique identifier of the resource
	 * @param (Mixed) (param1) first param sent in the request; Often subresource name
	 * @param (Mixed) (param2) Second param sent in the request: Often subresource ID
	 */
	public function run($id=null, $param1=null, $param2=null)
	{
		$this->finalRender(
			function($visibleProperties, $hiddenProperties) use($id, $param1, $param2) {
				switch ($this->getRequestActionType($id, $param1, $param2, 'get')) {
					case 'RESOURCES':
						
							if(isset($_GET['filter'])){
								$haystack = $_GET['filter'];
								$needle = "},";
								if (strpos($haystack,$needle) !== false) {
									$customFilter = new CustomFilter($_GET["filter"],true);
									return $this->controller->emitRest(ERestEvent::REQ_GET_RESOURCES_RENDER,[
										$customFilter->getRows(), $this->getModelName(), $this->getRelations(), $customFilter->getRowCount(),$visibleProperties, $hiddenProperties
									]);
								}else{
									$customFilter = new CustomFilter($_GET["filter"],false);
									return $this->controller->emitRest(ERestEvent::REQ_GET_RESOURCES_RENDER,[
										$customFilter->getRows(), $this->getModelName(), $this->getRelations(), $customFilter->getRowCount(),$visibleProperties, $hiddenProperties
									]);
								}
							}elseif(isset($_GET['group_by'])){
								if ($_GET["group_by"]=="ip") {
									$customGroupBy = new CustomGroupBy();
									return $this->controller->emitRest(ERestEvent::REQ_GET_RESOURCES_RENDER,[
										$customGroupBy->getRows(), $this->getModelName(), $this->getRelations(), $customGroupBy->getRowCount(),$visibleProperties, $hiddenProperties
									]);
								}
							}else{
								$customLog = new CustomLog();
								return $this->controller->emitRest(ERestEvent::REQ_GET_RESOURCES_RENDER,[
									$customLog->getRows(), $this->getModelName(), $this->getRelations(), $customLog->getRowCount(),$visibleProperties, $hiddenProperties
								]);
							}
							// return $this->controller->emitRest(ERestEvent::REQ_GET_RESOURCES_RENDER, [
							// 	$this->getModel($id), $this->getModelName(), $this->getRelations(), $this->getModelCount($id), $visibleProperties, $hiddenProperties
							// ]);
						
						break;
					case 'CUSTOM':
						return $this->controller->emitRest("req.get.$id.render", [$param1, $param2]);
						break;
					case 'SUBRESOURCES':
						return $this->controller->emitRest(ERestEvent::REQ_GET_SUBRESOURCES_RENDER, [
							$this->getSubresources($id, $param1), $this->getSubresourceClassName($param1), $this->getSubresourceCount($id, $param1, $param2), $visibleProperties, $hiddenProperties
						]);
						break;
					case 'SUBRESOURCE':
						return $this->controller->emitRest(ERestEvent::REQ_GET_SUBRESOURCE_RENDER, [
							$this->getSubresource($id, $param1, $param2), $this->getSubresourceClassName($param1), $this->getSubresourceCount($id, $param1, $param2), $visibleProperties, $hiddenProperties
						]);
						break;
					case 'RESOURCE':
						return $this->controller->emitRest(ERestEvent::REQ_GET_RESOURCE_RENDER, [
							$this->getModel($id), $this->getModelName(), $this->getRelations(), 1, $visibleProperties, $hiddenProperties
						]);
						break;
					default:
						throw new CHttpException(404, "Resource Not Found");
				}
			}	
		);
	}
}
