<?php require_once('./Connections/conn_books_db.php'); ?>
<?php
$SQLstring = "SELECT * FROM carousel WHERE caro_online=1 ORDER BY caro_sort";
$carousel = $link->query($SQLstring);
$i = 0; //控制active
?>


<div id="carouselIndexBanner" class="carousel slide mx-md-5" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php for ($i = 0; $i < $carousel->rowCount(); $i++) { ?>
            <button type="button" data-bs-target="#carouselIndexBanner" data-bs-slide-to="<?php echo $i; ?>" class="<?php echo activeShow($i, 0); ?>"
                aria-current="true" aria-label="Slide <?php echo $i; ?>"></button>
        <?php  } ?>
    </div>
    <div class="carousel-inner">
        <?php $i = 0;
        while ($data = $carousel->fetch()) { ?>
            <div class="carousel-item <?php echo activeShow($i, 0); ?>">
                <a href="./page_allproducts_book.php?search_name=<?php echo $data['p_name']; ?>"><img src="./pro_book_images/<?php echo $data['caro_pic']; ?>" class="d-block w-100" alt="<?php echo $data['caro_title']; ?>"></a>
            </div>
        <?php $i++;
        } ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndexBanner"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselIndexBanner"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


<?php
function activeShow($num, $chkPoint)
{
    return (($num == $chkPoint) ? "active" : "");
}
?>