<style>
    @font-face {
            font-family: 'Cambria' !important;
            src: url('../public/fonts/Cambria.woff2') format('woff2'),
                url('../public/fonts/Cambria.woff') format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
.hero-text h1,
.hero-text p {
    opacity: 0;
    transform: scale(0.3);
    animation: zoomReveal 1.8s ease-out forwards;
}

.hero-text p {
    animation-delay: 0.5s;
}
.hero-text h1,
.hero-text p {
    opacity: 0;
    transform: scale(0.2);
    animation: zoomOut 1.5s ease-out forwards;
}

.hero-text p {
    animation-delay: 0.3s;
}

@keyframes zoomOut {
    0% {
        opacity: 0;
        transform: scale(0.2);
    }

    100% {
        opacity: 1;
        transform: scale(1);
    }
}


.hero {
    position: relative;
    height: calc(100vh - 120px); 
    width: 100%;
    overflow: hidden;
}


.hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: url("<?= base_url('public/images/slide3.jpg'); ?>") no-repeat center center/cover;
    filter: blur(5px);
    transform: scale(1.1);
}


.hero::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.65);
}


.hero-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    z-index: 2;
}


.hero-text h1 {
    font-size: 52px;
    letter-spacing: 4px;
    font-family: 'Playfair Display', serif;
    text-transform: uppercase;
    text-shadow: 2px 2px 20px rgba(0,0,0,0.9);
    margin: 0;
     font-family: 'Cambria' !important;
}


.kumar {
    color: #ff9800; 
}

.associates {
    color: #4caf50;
}

.and {
    color: #ffffff;
}


.hero-text p {
    margin-top: 10px;
    font-size: 22px; 
    letter-spacing: 2px;
    color: #e0e0e0;
    font-weight: 500;
}
.hero-text h1 {
    font-size: 35px; 
    font-family: 'Playfair Display', serif;
    text-transform: uppercase;
    text-shadow: 2px 2px 20px rgba(0,0,0,0.9);
    margin: 0;
}
</style>

<div class="hero">
    <div class="hero-text">
        <h1>
            <span class="kumar">KUMAR SAMANTARAY</span>
            <span class="and">&</span>
            <span class="associates">ASSOCIATES</span>
        </h1>
        <p>CHARTERED ACCOUNTANTS</p>
    </div>
</div>