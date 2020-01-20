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
        <th>id</th>
        <th>name</th>
        <th>price</th>
        <th> </th>
    </tr>
    <?php foreach($products as $product): ?>
        <tr>
            <td><?php echo $product["id"]; ?></td>
            <td><?php echo $product["name"]; ?></td>
            <td><?php echo $product["price"]; ?>$</td>
            <td> </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php View::createChild("html-footer", $this, ["footerText" => "Copyright by me..."])->render(); ?> 