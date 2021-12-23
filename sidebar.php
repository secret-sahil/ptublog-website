<aside class="sidebar">
    <div class="category">
        <h2>Category</h2>
        <ul class="category-list">
            
                <?php
                    $stmt = $db->query('SELECT categoryName, categorySlug FROM sahil_category ORDER BY categoryId DESC');
                    while($row = $stmt->fetch()){
                        echo'<li class="list-items" data-aos="fade-left" data-aos-delay="100">';
                        echo '<a href="http://ptublog.in/category/'.$row['categorySlug'].'">'.$row['categoryName'].'</a>';
                        echo'</li>';
                    }
                ?>
            </li>
        </ul>
    </div>
    <div class="popular-post">
        <h2>Recent Articles</h2>
        <?php
        $sidebar = $db->query('SELECT * FROM sahil_blog where status="Published" ORDER BY articleId DESC LIMIT 3');
        while($row = $sidebar->fetch()){
            echo'<div class="post-content" data-aos="flip-up" data-aos-delay="300">';
            echo'<div class="post-image">
                    <div>
                        <img src="https://ptublog.in/assets/Blog-post/'.$row['featuredImg'].'" class="img"">
                    </div>
                    <div class="post-info flex-row">';
                        echo'<span><i class="fas fa-calendar-alt text-gray"></i>&nbsp;&nbsp;'.date('jS M Y', strtotime($row['articleDate'])).
                            '</span>';
                        // echo'<span>2 Commets</span>';
                    echo'</div>
                </div>';
                echo'<div class="post-title">';
                    
                        echo '<u> <a href="http://ptublog.in/'.$row['articleSlug'].'" >'.$row['articleTitle'].' </a></u>';
                        echo'</div>
                        </div> ';
                    }
               
            ?>
         </div>
    <div class="newsletter" data-aos="fade-up" data-aos-delay="300">
        <h2>Newsletter</h2>
        <div class="form-element">
            <input type="text" class="input-element" placeholder="Email">
            <button class="btn form-btn">Subscribe</button>
        </div>
    </div>
    </div>
</aside>