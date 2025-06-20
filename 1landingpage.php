<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAMERRA</title>
    <script src="https://kit.fontawesome.com/488d622bc0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        
    </style>
</head>

<body>
    <div id="wrapper">
        <div class="hero">
            <div class="inner-wrapper">
                <div class="header-nav">
                    <img class="logo" src="./img/logo.png">

                    <div class="search-container">

                        <div class="search">
                            <input class="text" id="searchInput" type="text" placeholder="Search for product?">
                            <a href="#" class="search-icon">
                                <i class="fa-solid fa-magnifying-glass" style="color: #6D2323;"></i>
                            </a>
                        </div>

                        <div class="search-results" id="resultsBox" style="display: none;">
                            
                        </div>

                    </div>



                    <div class="login" style="margin-left: 30px;">
                        <div class="login-item">
                            <a href="logout.php"><i class="fa-solid fa-arrow-right-to-bracket" style="color: #FEF9E1;"></i></a>
                            <a href="profile.php">profile</a>
                        </div>  
                    </div>
                </div>
                <div class="nav">
                    <div class="nav-item">
                        <a href="#kategori">Kategori</a>
                        <a href="#product">Product</a>
                        <a href="#brand">Brand</a>
                        <a href="#order">Order</a>
                        <a href="#review">Review</a>
                        <a href="./chart/cart.php"><i class="fa-solid fa-cart-shopping" style="color: #FEF9E1;"></i></a>
                    </div>
                </div>
                <h1 class="header-text">Temukan Kamera Impianmu, Abadikan Setiap Momen</h1>
                <p class="header-desc">Dari DSLR profesional hingga kamera mirrorless yang ringkas, kami menyediakan koleksi terbaik untuk setiap kebutuhan fotografi. Mulai petualangan visualmu hari ini!</p>
            </div>
        </div>
    </div>

    <div id="kategori" class="kategori">
        <h1 class="kategori-text">Kategori</h1>
        <div class="kategori-container1">
            <div class="kategori-frame">
                <img src="./img/ffkategori.png" alt="">
                <p class="kategori-desc">Compact Kamera</p>
            </div>
            <div class="kategori-frame">
                <img src="./img/ffkategori.png" alt="">
                <p class="kategori-desc">Compact Kamera</p>
            </div>
            <div class="kategori-frame">
                <img src="./img/ffkategori.png" alt="">
                <p class="kategori-desc">Compact Kamera</p>
            </div>
        </div>

        <div class="kategori-container2">
            <div class="kategori-frame">
                <img src="./img/dslrkategori.png" alt="">
                <p class="kategori-desc">DSLR</p>
            </div>
            <div class="kategori-frame">
                <img src="./img/dslrkategori.png" alt="">
                <p class="kategori-desc">DSLR</p>
            </div>
            <div class="kategori-frame">
                <img src="./img/dslrkategori.png" alt="">
                <p class="kategori-desc">DSLR</p>
            </div>
        </div>
    </div>

    <div id="product" class="product">
        <h1 class="product-text">Product</h1>
        <div class="product-container1">
            <div class="product-frame">
                <img src="./img/canonproduct.png" alt="">
                <p class="product-desc">Canon</p>
            </div>
            <div class="product-frame">
                <img src="./img/canonproduct.png" alt="">
                <p class="product-desc">Canon</p>
            </div>
            <div class="product-frame">
                <img src="./img/canonproduct.png" alt="">
                <p class="product-desc">Canon</p>
            </div>
        </div>
        <div class="product-container2">
            <div class="product-frame">
                <img src="./img/ffproduct.png" alt="">
                <p class="product-desc">Fujifim</p>
            </div>
            <div class="product-frame">
                <img src="./img/ffproduct.png" alt="">
                <p class="product-desc">Fujifilm</p>
            </div>
            <div class="product-frame">
                <img src="./img/ffproduct.png" alt="">
                <p class="product-desc">Fujifilm</p>
            </div>
        </div>
    </div>

    <div id="brand" class="brand">
        <h1 class="brand-text">Brand</h1>
        <div class="brand-container">
            <div class="brand-frame">
                <img src="./img/canonbrand.png" alt="">
                <p class="brand-desc">Canon</p>
            </div>
            <div class="brand-frame">
                <img src="./img/ffbrand.png" alt="">
                <p class="brand-desc">Fujifilm</p>
            </div>
            <div class="brand-frame">
                <img src="./img/canonbrand.png" alt="">
                <p class="brand-desc">Canon</p>
            </div>
            <div class="brand-frame">
                <img src="./img/ffbrand.png" alt="">
                <p class="brand-desc">Fujifilm</p>
            </div>
        </div>
    </div>

    <div id="order" class="order">
        <h1 class="order-text">Order</h1>
        <div class="order-container1">
            <img class="order-img" src="./img/bgorder.png" alt="">
            <p class="order-title">GET YOUR<br>KAMERA</p>
        </div>
        <div class="order-container2">
    <div class="order-frame">
        <img src="./img/fforder.png" alt="">
        <p class="order-desc">FUJIFILM FINEPIX A800</p>
        <p class="order-price">Rp 250.000</p>
        <div class="order-icon">
            <button class="add-to-cart-btn" data-id="1"><i class="fa-solid fa-plus"></i></button>
        </div>
    </div>
    <div class="order-frame">
        <img src="./img/fforder.png" alt="">
        <p class="order-desc">FUJIFILM GFX100 II</p>
        <p class="order-price">Rp 500.000</p>
        <div class="order-icon">
            <button class="add-to-cart-btn" data-id="2"><i class="fa-solid fa-plus"></i></button>
        </div>
    </div>
    <div class="order-frame">
        <img src="./img/fforder.png" alt="">
        <p class="order-desc">FUJIFILM GFX100 II</p>
        <p class="order-price">Rp 1.500.000</p>
        <div class="order-icon">
            <button class="add-to-cart-btn" data-id="3"><i class="fa-solid fa-plus"></i></button>
        </div>
    </div>
    <div class="order-frame">
        <img src="./img/fforder.png" alt="">
        <p class="order-desc">FUJIFILM GFX50S II</p>
        <p class="order-price">Rp 2.500.000</p>
        <div class="order-icon">
            <button class="add-to-cart-btn" data-id="4"><i class="fa-solid fa-plus"></i></button>
        </div>
    </div>
</div>

        </div>
    </div>

    <div id="review" class="review">
        <h1 class="review-text">Review</h1>
        <div class="review-container">
            <div class="review-frame">
                <img src="./img/canonreview.png" alt="">
                <p class="review-nama">Alex</p>
                <p class="review-desc">Canon memberikan hasil foto yang natural, cocok untuk penggunaan sehari-hari maupun traveling.</p>
            </div>
            <div class="review-frame">
                <img src="./img/canonreview.png" alt="">
                <p class="review-nama">Alex</p>
                <p class="review-desc">Canon memberikan hasil foto yang natural, cocok untuk penggunaan sehari-hari maupun traveling.</p>
            </div>
            <div class="review-frame">
                <img src="./img/canonreview.png" alt="">
                <p class="review-nama">Alex</p>
                <p class="review-desc">Canon memberikan hasil foto yang natural, cocok untuk penggunaan sehari-hari maupun traveling.</p>
            </div>
        </div>
    </div>
 <footer class="footer">
        <div class="footer-container">
            <div class="footer-section1">
                <img class="footer-logo" src="./img/logo.png" alt="">
                <p class="footer-desc">Kamera klasik berkualitas <br>untuk kenangan tak terlupakan.</p>
            </div>
            <div class="footer-section2">
                <h1 class="footer-title">Navigasi</h1>
                <ul class="title-nav">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Produk</a></li>
                    <li><a href="#">Brand</a></li>
                    <li><a href="#">Review</a></li>
                </ul>
            </div>
            <div class="footer-section3">
                <h1 class="footer-title">Kontak</h1>
                <p class="footer-info">📍 Jl. Kaliurang Km.5, Sinduadi, Sleman, Yogyakarta</p>
                <p class="footer-info">✉ info@camerrastore.com</p>
                <p class="footer-info">☎ 0812-3456-7890</p>
            </div>
        </div>
        <div class="footer-bottom">
            © 2025 Camerra Store. All rights reserved.
        </div>
    </footer> 
</body>


<!-- script handle search -->
<script>
    const input = document.getElementById('searchInput');
    const resultsBox = document.getElementById('resultsBox');

    input.addEventListener('input', function() {
        const query = this.value.trim();

        if (query === '') {
            resultsBox.style.display = 'none';
            resultsBox.innerHTML = '';
            return;
        }


        fetch('search.php?q=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                resultsBox.innerHTML = '';

                const title = document.createElement('h4')
                title.textContent = "Product"
                title.style = "margin-left: 10px; margin-top: 10px; color:white; margin-bottom: 10px;"

                resultsBox.appendChild(title)
                if (data.length > 0) {
                    data.forEach(product => {
                        const item = document.createElement('div');
                        item.classList.add('search-item');

                        const img = document.createElement('img');
                        img.classList.add('product-thumb');
                        img.src = './img/' + product.gambar; // pastikan path sesuai
                        img.alt = product.nama;

                        const info = document.createElement('div');
                        info.classList.add('product-info');

                        const name = document.createElement('div');
                        name.classList.add('name');
                        name.textContent = product.nama;

                        const price = document.createElement('div');
                        price.classList.add('price');
                        price.textContent = 'Rp ' + Number(product.price).toLocaleString();

                        info.appendChild(name);
                        info.appendChild(price);

                        item.appendChild(img);
                        item.appendChild(info);

                        item.addEventListener('click', function() {
                            window.location.href = '#order';
                              resultsBox.style.display = 'none';
                        });

                        resultsBox.appendChild(item);
                    });
                    resultsBox.style.display = 'block';
                } else {
                    const notFound = document.createElement('div');
                    notFound.classList.add('search-item');
                    notFound.textContent = 'Produk tidak ditemukan';
                    resultsBox.appendChild(notFound);
                    resultsBox.style.display = 'block';
                }
            });


    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-container')) { 
            resultsBox.style.display = 'none';
        }
    });
</script>
<!-- script handle search -->

<script>
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;

            fetch('chart/add_to_cart.php?id=' + productId)
                .then(response => response.json()) 
                .then(data => {
                    alert(data.message); 
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Gagal menambahkan produk.');
                });
        });
    });
</script>



</html>