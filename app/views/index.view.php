<?php 
namespace Alddesign\EzMvc; 
use Alddesign\EzMvc\System\Config;
use Alddesign\EzMvc\System\Helper;
use Alddesign\EzMvc\System\View;
?>

<!-- 
    When creating a view within a view, make sure to create a CHILD view.
    Views are created bottom-up:
    =>html-header (child)
    =>=>index (root)
    =>html-footer (child)
-->
<?php View::createChild("html-header", $this)->render(); ?> 

<h2>
    <?php echo Config::get("title") ?>
</h2>
Come and check out our <a href="<?php Helper::echoUrl("/Product/list") ?>">products</a>

<!-- You can also pass some data to a child view -->
<?php View::createChild("html-footer", $this, ["footerText" => "Copyright by me..."])->render(); ?> 