<ul class="breadcrumb">
    <?php 
    $icon = '<i class="icon-home2 position-left"></i> ';
    foreach($this->crumbs as $i => $crumb) 
    {
        if(isset($crumb['url']) && $i < count($this->crumbs) - 1)
            echo '<li><a href="' . $crumb['url'] . '">' . $icon . $crumb['name'] . '</a></li>';
        else
            echo '<li class="active">'. $icon . $crumb['name'].'</li>';
        $icon = '';
    }
    ?>
</ul>
