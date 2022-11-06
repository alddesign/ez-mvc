<?php 
namespace Alddesign\EzMvc; 
use Alddesign\EzMvc\System\Config;
use Alddesign\EzMvc\System\Helper;
use Alddesign\EzMvc\System\View;
?>

<?php View::createChild("html-header", $this)->render(); ?> 
<style>
    table,tr,td,th{border-collapse: collapse; border:1px solid gray;}
    td,th{padding: 5px;}
</style>

<table>
    <tr>
        <th><?php echo Config::get("captions.id"); ?></th>
        <th><?php echo Config::get("captions.name"); ?></th>
        <th><?php echo Config::get("captions.price"); ?></th>
        <th> </th>
        <th> </th>
    </tr>
    <!-- list all products -->
    <?php foreach($products as $product): ?>
        <?php 
        $id = $product["id"];
        $activateUrl = Helper::url("/Product/setStatus/$id/1"); //Creating urls fast & save
        $deactivateUrl = Helper::url("/Product/setStatus/$id/0");    
        ?>
        <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $product["name"]; ?></td>
            <td><?php echo $product["price"]; ?></td>
            <?php if($product["active"] == 1): ?>
                <td><span style="color: green;">active</span></td>
                <td><a href="<?php echo $deactivateUrl ?>">deactivate product</a></td>
            <?php endif; ?>
            <?php if($product["active"] != 1): ?>
                <td><span style="color: red;">in-active</span></td>
                <td><a href="<?php echo $activateUrl ?>">activate product</a></td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    <!-- Add Product -->
    <form method="POST" action="<?php Helper::echoUrl("/Product/add") ?>">
    <tr>
            <td><input type="text" name="id" value="" /></td>
            <td><input type="text" name="name" value="" /></td>
            <td><input type="text" name="price" value="" /></td>
            <td><input type="submit" value="Add" /></td>
            <td> </td>
    </tr>
    </form>
</table>

<?php View::createChild("html-footer", $this, false, ["footerText" => "Copyright by me..."])->render(); ?> 