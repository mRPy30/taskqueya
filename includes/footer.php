<style>
    /****** Footer *******/

.footer-page {
    width: 100%;
    background-color: #FBF4F4;
    padding: 20px 0 0px 0px;
}

.footer {
    display: flex;
    flex-direction: row;
    margin: 0px 30px 0px 90px;
}

.footer-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 3.5rem;
    width: 33%;
    padding: 15px 60px 0px 60px;
}

.footer-left-link {
    margin-top: 20px;
}

.footer-left-link li {
    list-style: none;
    margin-bottom: 10px;
}

.footer-left-link li a {
    text-decoration: none;
    color: #1C1C1D;
    font: normal 500 14px/normal 'Poppins';
    line-height: 30px;
}

.footer-left-link li a:hover {
    color: #C2BE63;
}

.footer-left-link a:hover {
    color: #C2BE63;
    transition: all 0.3s;
}

.footer-center-content {
    padding: 30px 50px 50px 50px;
}

.vertical-line-left {
    border-left: 2px solid #000;
    height: 250px;
}

.footer-center h6 {
    font: normal 700 18px/normal 'Poppins';
}

.footer-center p {
    font: normal 700 18px/normal 'Poppins';
    color: #1C1C1D;
    font-family: Poppins;
    font: normal 15px/normal 'Poppins';
    width: 90%;
    flex-shrink: 0;
    margin-top: 15px;
    text-align: center;
    line-height: 20px;
    letter-spacing: 0.3px;
}

.social-meadia-links .icons {
    display: flex;
    gap: 15px;
    cursor: pointer;
}

.social-meadia-links .icons a i {
    color: #1C1C1D;
    font-size: 140%;
    font-weight: bold;
}

.social-meadia-links .icons a i:hover {
    color: #454548;
}

.vertical-line-right {
    border-left: 2px solid #000;
    height: 250px;
}

.footer-logo {
    margin: 70px 50px 20px 60px;
}

.footer-logo img {
    width: 200px;
    height: 110px;
}

.container-credential {
    width: 100%;
    background-color: #1C1C1D;
}

.rights-definition {
    padding: 15px;
}

.rights-definition p {
    font: normal 14px/normal 'Poppins';
    color: #ccc;
    text-align: center;
}

.grid-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 10px;
}

.grid-item {
    padding: 20px;
    background-color: #f1f1f1;
    text-align: center;
}

.featured-project {
    grid-column: 1 / -1;
}
</style>


<section class="footer-page">
    <div class="footer">
        <div class="footer-row">

        </div>
        <div class="vertical-line-left"></div>
        <div class="footer-center-content">
            <div class="footer-center">
                <div class="social-meadia-links">
                    <h6>FOOTER</h6>
                    <div class="icons">
                        <a class="facebook" href="https://www.facebook.com/icsmcreatives" target="_blank"><i
                                class="fa-brands fa-facebook"></i>
                        </a>
                        <a class="instagram" href="https://www.instagram.com/icsmcreatives">
                            <i class=" fa-brands fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="vertical-line-right"></div>
        <div class="footer-logo">
            <img src="../Logo-TQ.png" alt="logo">

        </div>
    </div>
</section>
