<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Mikolaj Jedrzejewski <mj@plusb.de>, plusB
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package pb_besocial
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_PbBesocial_Controller_ItemController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * itemRepository
	 *
	 * @var Tx_PbBesocial_Domain_Repository_ItemRepository
	 */
	protected $itemRepository;

	/**
	 * injectItemRepository
	 *
	 * @param Tx_PbBesocial_Domain_Repository_ItemRepository $itemRepository
	 * @return void
	 */
	public function injectItemRepository(Tx_PbBesocial_Domain_Repository_ItemRepository $itemRepository) {
		$this->itemRepository = $itemRepository;
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$items = $this->itemRepository->findAll();
		$this->view->assign('items', $items);
	}

	/**
	 * action show
	 *
	 * @param Tx_PbBesocial_Domain_Model_Item $item
	 * @return void
	 */
	public function showAction(Tx_PbBesocial_Domain_Model_Item $item) {
		$this->view->assign('item', $item);
	}

    /**
     * action showSocialBarAction
     * @return void
     */
    public function showSocialBarAction() {
        // function has nothing to do with database => only as template ref dummy
        // the magic is located only in the template and main.js :)
    }

    /**
     * action showSocialListAction
     * @return void
     */
    public function showSocialFeedAction() {
        $feeds = null;
        $feeds_facebook = null;
        $feeds_googleplus = null;
        $feeds_instagram = null;
        $feeds_twitter = null;
        $AccId = "226066384147152";

        if($this->settings["sf_facebook"] != 0){
            $feeds_facebook = $this->itemRepository->findFeedsByType("facebook");
//            $this->itemRepository->writeLog(
//                'NOTICE',
//                'Facebook ausführen',
//                array($feeds_facebook)
//            );
            if($feeds_facebook !== NULL){

                $this->view->assign('feeds_facebook', $feeds_facebook);
                foreach($feeds_facebook->getResult()->data as $rawFeed){
                    if($rawFeed->picture == "" || $rawFeed->message == ""){ continue; }
                    if($rawFeed->from->id != $AccId){ continue; }

//                    if($rawFeed->id == "226066384147152_697680396985746"){
//                        echo "<pre>".print_r($rawFeed,true)."</pre>";
//                    }

                    $feed = new Feed();
                    $feed->setId($rawFeed->id);
                    $feed->setProvider($feeds_facebook->getType());
                    $feed->setRaw($rawFeed);
                    $feed->setText(trim_text($rawFeed->message,85,true));
                    $feed->setImage($rawFeed->picture);
                    $feed->setLink($rawFeed->link);
                    $d = new DateTime($rawFeed->created_time);
                    $feed->setTimeStampTicks($d->getTimestamp());
                    $feeds[] = $feed;
                }
            }
        }

        if($this->settings["sf_googleplus"] != 0){
            $feeds_googleplus = $this->itemRepository->findFeedsByType("googleplus");

            if($feeds_googleplus !== NULL){

                $this->view->assign('feeds_googleplus', $feeds_googleplus);
                foreach($feeds_googleplus->getResult()->items as $rawFeed){
                    if($rawFeed->object->attachments[0]->image->url == ""){ continue; }
                    $feed = new Feed();
                    $feed->setId($rawFeed->id);
                    $feed->setProvider($feeds_googleplus->getType());
                    $feed->setRaw($rawFeed);
                    $feed->setText(trim_text($rawFeed->title,105,true));
                    $feed->setImage($rawFeed->object->attachments[0]->image->url);

                    // only for type photo
                    if($rawFeed->object->attachments[0]->objectType == "photo" && $rawFeed->object->attachments[0]->fullImage->url != ""){
                        $feed->setImage($rawFeed->object->attachments[0]->fullImage->url);
                    }

                    // only if no title is set but somehow the video is labeled
                    if($rawFeed->title == "" && $rawFeed->object->attachments[0]->displayName != ""){
                        $feed->setText(trim_text($rawFeed->object->attachments[0]->displayName,105,true));
                    }

                    $feed->setLink($rawFeed->url);
                    $d = new DateTime($rawFeed->updated);
                    $feed->setTimeStampTicks($d->getTimestamp());
                    $feeds[] = $feed;
                }
            }
        }

        if($this->settings["sf_instagram"] != 0){
            $feeds_instagram = $this->itemRepository->findFeedsByType("instagram");

            if($feeds_instagram !== NULL){

                //$this->view->assign('feeds_instagram', $feeds_instagram);
                foreach($feeds_instagram->getResult()->data as $rawFeed){
                    if($rawFeed->images->standard_resolution->url == "" || $rawFeed->caption == ""){ continue; }
                    $feed = new Feed();
                    $feed->setId($rawFeed->id);
                    $feed->setProvider($feeds_instagram->getType());
                    $feed->setRaw($rawFeed);
                    $feed->setText(trim_text($rawFeed->caption,85,true));
                    $feed->setImage($rawFeed->images->standard_resolution->url);
                    $feed->setLink($rawFeed->link);
                    $feed->setTimeStampTicks($rawFeed->created_time);
                    $feeds[] = $feed;
                }
            }

        }

        if($this->settings["sf_twitter"] != 0){
            $feeds_twitter = $this->itemRepository->findFeedsByType("twitter");
//            $this->view->assign('feeds_twitter', $feeds_twitter);

//            echo "<pre>".print_r($feeds_twitter->getResult(),true)."</pre>";


//            foreach($feeds_twitter->getResult()->data as $rawFeed){
//                if($rawFeed->images->standard_resolution->url == "" || $rawFeed->caption == ""){ continue; }
//                $feed = new Feed();
//                $feed->setId($rawFeed->id);
//                $feed->setProvider($feeds_twitter->getType());
//                $feed->setText(trim_text($rawFeed->caption,85,true));
//                $feed->setImage($rawFeed->images->standard_resolution->url);
//                $feed->setLink($rawFeed->link);
//                $feed->setRaw($rawFeed);
//                $feed->setTimeStampTicks($rawFeed->created_time);
//                $feeds[] = $feed;
//            }
        }

        usort($feeds,array($this,"cmp"));    // sort array
        $this->view->assign('feeds', $feeds);
    }

    /**
     * @param $url
     */
    public function showContentForUrlAction($url) {
        $this->view->assign('content', $this->itemRepository->findContentByUrl($url));
    }

    public function cmp($a, $b)
    {
        if ($a == $b) { return 0; }
        return ($a->getTimeStampTicks() > $b->getTimeStampTicks()) ? -1 : 1;
    }
}

class Feed{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $Provider;

    /**
     * @var string
     */
    protected $Image;

    /**
     * @var string
     */
    protected $Text;

    /**
     * @var integer
     */
    protected $TimeStampTicks;

    /**
     * @var string
     */
    protected $Link;

    /**
     * @var string
     */
    protected $Raw;




    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $Image
     */
    public function setImage($Image)
    {
        if($this->Provider == "facebook"){
            $Image = str_replace("/v/","/",$Image);
            $Image = str_replace("/p130x130/","/p/",$Image);

            if($this->Raw->type == "link"){
                $Image = preg_replace('/&[wh]=[0-9]*/', '', $Image); // for embedded links
            }
            if($this->Raw->type == "video"){

            }
        }
        $this->Image = $Image;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->Image;
    }

    /**
     * @param string $Provider
     */
    public function setProvider($Provider)
    {
        $this->Provider = $Provider;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->Provider;
    }

    /**
     * @param string $Raw
     */
    public function setRaw($Raw)
    {
        $this->Raw = $Raw;
    }

    /**
     * @return string
     */
    public function getRaw()
    {
        return $this->Raw;
    }

    /**
     * @param string $Text
     */
    public function setText($Text)
    {
        $this->Text = $Text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->Text;
    }

    /**
     * @param int $TimeStampTicks
     */
    public function setTimeStampTicks($TimeStampTicks)
    {
        $this->TimeStampTicks = $TimeStampTicks;
    }

    /**
     * @return int
     */
    public function getTimeStampTicks()
    {
        return $this->TimeStampTicks;
    }

    /**
     * @param string $Link
     */
    public function setLink($Link)
    {
        $this->Link = $Link;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->Link;
    }
}

/**
 * trims text to a space then adds ellipses if desired
 * @param string $input text to trim
 * @param int $length in characters to trim to
 * @param bool $ellipses if ellipses (...) are to be added
 * @param bool $strip_html if html tags are to be stripped
 * @return string
 */
function trim_text($input, $length, $ellipses = true, $strip_html = true) {
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }

    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }

    //find last space within length
    $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);

    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= '...';
    }

    return $trimmed_text;
}
?>