<?php 
namespace Alddesign\EzMvc; 
use Alddesign\EzMvc\System\Config;
use Alddesign\EzMvc\System\View;
?>

<?php View::createChild("html-header", $this)->render(); ?> 

<style>
    td{padding: 2px 20px 2px 0;}
</style>

<!-- Here make syntax easier, shot tags and the product as an object -->
<h1><?= $product->name ?></h1>
<table> 
    <tr>
        <td><b><?= Config::get("captions.id") ?>:</b></td>
        <td><?= $product->id ?><br></td>
    <tr>
    </tr>
        <td><b><?= Config::get("captions.name") ?>:</b></td>
        <td><?= $product->name ?><br></td>
    <tr>
    </tr>
        <td><b><?= Config::get("captions.price") ?>:</b></td>
        <td><?= $product->price ?><br></td>
    <tr>
    </tr>
        <td><b><?= Config::get("captions.active") ?>:</b></td>
        <td><?= $product->active ?><br></td>
    </tr>
</table>

<?php View::createChild("html-footer", $this, false, ["footerText" => "Copyright by me..."])->render(); ?> 