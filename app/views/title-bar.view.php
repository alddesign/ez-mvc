<?php 
namespace Alddesign\EzMvc;

use Alddesign\EzMvc\System\Helper;

?>

<div id="title-bar" style="width:100%; height: 24px; position:fixed; top: 0; left:0; border:1px solid #444; background-color:#ccc; padding: 5px 10px;">
    <!--
    Now this is cool:
    Within child views its possible to access all its parent view´s data: 
    Imagine views as  pathe like root/child/child... you can even get this path as as string: $this->path;

    Use:
    $this->getRootView() to get the first View object (which you mostly create form a controller)
    $this->getParentView($level = 0) to get the parent view. $level 0 = paren, $level 1 = parent of parent, and so on

    You can even access a parents view data array like this: $this->getParentView()->data
     -->
    <a href="<?php Helper::echoUrl("/Main/index") ?>"><h3 style="display: inline; margin-right: 10px;">EZ-MVC</h3></a>
    <h3 style="display: inline; margin-right: 10px;"><?php echo $this->getRootView()->name; ?></h3>
    <h4 style="display: inline; color:#666;"><?php echo $this->path; ?></h4>
</div>