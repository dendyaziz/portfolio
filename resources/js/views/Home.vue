<template>
    <section>
        <Navbar v-model="isScrolled"/>

        <div id="hi" class="info-section">
            <div class="container">
                <div class="columns pt-5 reverse-order">
                    <div class="column">
                        <h1 class="main-title">I am <span class="point">Dendy Armandiaz</span></h1>
                        <p class="main-desc">I am a Frontend Developer living in Bekasi, Indonesia. I recently work as a
                            freelance Remote Web Developer for Telkom University, located in Bandung. I am looking to
                            collaborate with you as a Frontend Developer.</p>
                        <div class="columns mb-0 is-mobile">
                            <div class="column mb-0 is-3-desktop is-4-mobile info-title">Whatsapp</div>
                            <div class="column mb-0"><span class="mr-1">+62</span><span class="mr-1">896</span><span
                                    class="mr-1">0943</span><span>3526</span></div>
                        </div>
                        <div class="columns mb-0 is-mobile">
                            <div class="column mb-0 is-3-desktop is-4-mobile info-title">Email</div>
                            <div class="column mb-0">dendy.aziz@gmail.com</div>
                        </div>
                        <div class="columns mb-0 is-mobile">
                            <div class="column mb-0 is-3-desktop is-4-mobile info-title">Address</div>
                            <div class="column mb-0">East Cikarang, Bekasi, Indonesia 17825</div>
                        </div>
                        <div class="columns is-mobile">
                            <div class="column is-3-desktop is-4-mobile info-title">Social</div>
                            <div class="column is-narrow">
                                <b-tooltip label="LinkedIn" type="is-dark" delay="500">
                                    <a href="https://linkedin.com/in/dendyaziz" target="_blank">
                                        <b-icon pack="fab" icon="linkedin-in" size="is-small"></b-icon>
                                    </a>
                                </b-tooltip>
                            </div>
                            <div class="column is-narrow">
                                <b-tooltip label="Instagram" type="is-dark" delay="500">
                                    <a href="https://instagram.com/dendyaziz" target="_blank">
                                        <b-icon pack="fab" icon="instagram" size="is-small"></b-icon>
                                    </a>
                                </b-tooltip>
                            </div>
                            <div class="column is-narrow">
                                <b-tooltip label="GitHub" type="is-dark" delay="500">
                                    <a href="https://github.com/dendyaziz" target="_blank">
                                        <b-icon pack="fab" icon="github" size="is-small"></b-icon>
                                    </a>
                                </b-tooltip>
                            </div>
                            <div class="column is-narrow">
                                <b-tooltip label="Dribbble" type="is-dark" delay="500">
                                    <a href="https://dribbble.com/dendyaziz" target="_blank">
                                        <b-icon pack="fab" icon="dribbble" size="is-small"></b-icon>
                                    </a>
                                </b-tooltip>
                            </div>
                        </div>
                        <div class="columns mt-4 py-3">
                            <div class="column is-narrow py-1">
                                <b-button type="is-primary" class="is-boxy" expanded>Contact Me</b-button>
                            </div>
                            <div class="column is-narrow py-1">
                                <b-button type="is-light" class="is-boxy" expanded>Download CV</b-button>
                            </div>
                        </div>
                    </div>
                    <div class="column has-text-centered">
                        <img src="https://i.ibb.co/N9Hxzdn/Profile-Picture.png" class="profile-picture image-fit"
                             alt="Profile Picture">
                    </div>
                </div>
            </div>
        </div>

        <div id="skills" class="info-section">
            <div class="container">
                <div class="columns py-5">
                    <div class="column is-one-thirds">
                        <h2 class="info-title"><span class="point">Skills</span></h2>
                        <p class="mb-4">I am inspired by creating great work with people who are as passionate as I am
                            about
                            building something beautiful.</p>
                        <div class="wave is-hidden-touch">
                            <div class="zigzag">
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-light"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-light"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-light"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-light"></b-icon>
                            </div>
                            <div class="zigzag">
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-primary"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-primary"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-primary"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-primary"></b-icon>
                            </div>
                        </div>
                    </div>

                    <div class="column is-two-thirds">
                        <div class="columns pt-2 is-multiline">
                            <div class="column is-half py-0">
                                <h4 class="info-subtitle">Web Development</h4>
                                <p>Javascript, Coffeescript, JAVA, Python, PHP, Go, Node.js, MongoDB, Redis, PostgreSQL,
                                    WebStorm.</p>
                            </div>
                            <div class="column is-half py-0">
                                <hr class="is-hidden-tablet">
                                <h4 class="info-subtitle">UI\UX Design</h4>
                                <p>Photoshop, Illustrator, Sketch, Axure, XMind, Prototyping, Wireframing, User
                                    Research,
                                    Usability Testing.</p>
                            </div>
                            <div class="column is-half py-0">
                                <hr>
                                <h4 class="info-subtitle">Frontend Development</h4>
                                <p>HTML, CSS, LESS, SASS, Bootstrap, Wordpress, Drupal, Phonegap / Cordova, Ionic,
                                    Foundation, Angular.js.</p>
                            </div>
                            <div class="column is-half py-0">
                                <hr>
                                <h4 class="info-subtitle">Image Editing</h4>
                                <p>Screaming Frog, Woorank, Raventools, Semrush, Moz, WebCEO, Google Analytics,
                                    ChartBeat,
                                    CrazyEgg.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="experience" class="info-section">
            <div class="container">
                <div class="columns py-5">
                    <div class="column is-one-thirds">
                        <h2 class="info-title"><span class="point">Experience</span></h2>
                        <p class="mb-4">I partner with startups, university and also individual person to build digital
                            products that help my clients overcome challenges and create lasting connections with tons
                            of
                            people every day.</p>
                        <div class="wave is-hidden-touch">
                            <div class="zigzag">
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-light"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-light"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-light"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-light"></b-icon>
                            </div>
                            <div class="zigzag">
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-primary"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-primary"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-primary"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-primary"></b-icon>
                            </div>
                        </div>
                    </div>

                    <div class="column is-two-thirds">
                        <div class="columns pt-2 is-multiline">
                            <div class="column is-full py-0">
                                <h4>
                                    <span class="has-text-weight-semibold mr-1">Web Developer</span>
                                    <span class="has-text-weight-normal">Telkom University</span>
                                </h4>
                                <p class="mb-3">May, 2014 - Present</p>
                                <i>Designed and developed user-friendly website, including optimized check-out page that
                                    increased user clicks, and subsequently customer purchases by 20%.</i>
                            </div>
                            <div class="column is-full py-0">
                                <hr>
                                <h4>
                                    <span class="has-text-weight-semibold mr-1">Web Developer</span>
                                    <span class="has-text-weight-normal">Telkom University</span>
                                </h4>
                                <p class="mb-3">May, 2014 - Present</p>
                                <i>Designed and developed user-friendly website, including optimized check-out page that
                                    increased user clicks, and subsequently customer purchases by 20%.</i>
                            </div>
                            <div class="column is-full py-0">
                                <hr>
                                <h4>
                                    <span class="has-text-weight-semibold mr-1">Web Developer</span>
                                    <span class="has-text-weight-normal">Telkom University</span>
                                </h4>
                                <p class="mb-3">May, 2014 - Present</p>
                                <i>Designed and developed user-friendly website, including optimized check-out page that
                                    increased user clicks, and subsequently customer purchases by 20%.</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="education" class="info-section">
            <div class="container">
                <div class="columns py-5">
                    <div class="column is-one-thirds">
                        <h2 class="info-title"><span class="point">Education</span></h2>
                        <p class="mb-4">All my life I have been driven by my strong belief that education is important.
                            I
                            try to learn something new every single day.</p>
                        <div class="wave is-hidden-touch">
                            <div class="zigzag">
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-light"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-light"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-light"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-light"></b-icon>
                            </div>
                            <div class="zigzag">
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-primary"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-primary"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-primary"></b-icon>
                                <b-icon pack="fas" icon="chevron-down" size="is-large" type="is-primary"></b-icon>
                            </div>
                        </div>
                    </div>

                    <div class="column is-two-thirds">
                        <div class="columns pt-2 is-multiline">
                            <div class="column is-full py-0">
                                <h4>
                                    <span class="has-text-weight-semibold mr-1">Information System</span>
                                    <span class="has-text-weight-normal">Telkom University</span>
                                </h4>
                                <p class="mb-3">May, 2016 - July, 2020</p>
                                <i>Designed and developed user-friendly website, including optimized check-out page that
                                    increased user clicks, and subsequently customer purchases by 20%.</i>
                            </div>
                            <div class="column is-full py-0">
                                <hr>
                                <h4>
                                    <span class="has-text-weight-semibold mr-1">Web Developer</span>
                                    <span class="has-text-weight-normal">Telkom University</span>
                                </h4>
                                <p class="mb-3">May, 2014 - Present</p>
                                <i>Designed and developed user-friendly website, including optimized check-out page that
                                    increased user clicks, and subsequently customer purchases by 20%.</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="portfolio" class="info-section">
            <div class="container">
                <div class="py-5">
                    <h2 class="info-title mb-3"><span class="point">Portfolio</span></h2>
                    <a class="filter-link">All Projects</a>
                    <a class="filter-link">Frontend</a>
                    <a class="filter-link">Web Sites</a>
                    <a class="filter-link">Mobile</a>

                    <div class="columns is-mobile is-multiline mt-2">
                        <div class="column is-half-touch is-one-quarter-desktop" v-for="a in [1, 2, 3]">
                            <a href="" class="portfolio-box">
                                <b-image
                                        src="https://i.ibb.co/85fS9WW/manawa.png"
                                        alt="A random image"
                                        class="portfolio-img"
                                        ratio="1by1">
                                </b-image>
                                <h4 class="portfolio-title">Investment app "Manawa"</h4>
                                <p class="portfolio-date">May, 2020</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    </section>
</template>
<script>

    import Navbar from "../layouts/Navbar";
    import BIcon from "buefy/src/components/icon/Icon";

    export default {
        components: {BIcon, Navbar},
        data() {
            return {
                isScrolled: false
            }
        },
        methods: {
            onScroll() {
                this.isScrolled = window.scrollY > 0;
            }
        },
        mounted: function () {
            window.addEventListener('scroll', this.onScroll);
        },
        destroyed: function () {
            window.removeEventListener('scroll', this.onScroll);
        }
    }
</script>
