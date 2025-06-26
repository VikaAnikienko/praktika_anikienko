    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>FURRA</h3>
                    <p>Элитная мебель ручной работы для самых требовательных клиентов.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>

                <div class="footer-column">
                    <h3>Компания</h3>
                    <ul>
                        <li><a href="#">О нас</a></li>
                        <li><a href="#">Мастерские</a></li>
                        <li><a href="#">Карьера</a></li>
                        <li><a href="#">Пресса</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Контакты</h3>
                    <ul>
                        <li>Барнаул, ул. Попова, 256</li>
                        <li>+7 9627983118</li>
                        <li>im-furra@yandex.com</li>
                        <li>Пн-Пт: 10:00 - 20:00</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 FURRA. Все права защищены.</p>
            </div>
        </div>
    </footer>
<style>
/* Footer */
footer {
  background-color: var(--dark);
  color: var(--light);
  padding: 60px 0 20px;
}

.footer-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 40px;
  margin-bottom: 40px;
}

.footer-column h3 {
  color: var(--gold);
  margin-bottom: 20px;
  font-size: 18px;
}

.footer-column ul {
  list-style: none;
}

.footer-column ul li {
  margin-bottom: 10px;
}

.footer-column ul li a {
  color: var(--light);
  text-decoration: none;
  transition: color 0.3s ease;
}

.footer-column ul li a:hover {
  color: var(--gold);
}

.social-links {
  display: flex;
  gap: 15px;
}

.social-links a {
  color: var(--light);
  font-size: 20px;
  transition: color 0.3s ease;
}

.social-links a:hover {
  color: var(--gold);
}

.copyright {
  text-align: center;
  padding-top: 20px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  font-size: 14px;
}
</style>