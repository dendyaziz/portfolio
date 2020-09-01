<template>
    <section>
        <Navbar/>
        <div class="container">
            <div class="columns reverse-order">
                <div class="column">
                    <h1 class="has-text-weight-semibold mb-2">I am <span class="point">Dendy Armandiaz</span></h1>
                    <h4 class="mb-4">I am a Front-end Developer living in Bekasi, Indonesia. I recently work as a
                        freelance Remote Web Developer for Telkom University, located in Bandung. I am looking to
                        collaborate with you as a Front-end Developer.</h4>
                    <div class="columns mb-0 is-mobile">
                        <div class="column is-3-desktop is-4-mobile info-title">Whatsapp</div>
                        <div class="column"><span class="mr-1">+62</span><span class="mr-1">896</span><span
                                class="mr-1">0943</span><span>3526</span></div>
                    </div>
                    <div class="columns mb-0 is-mobile">
                        <div class="column is-3-desktop is-4-mobile info-title">Email</div>
                        <div class="column">dendy.aziz@gmail.com</div>
                    </div>
                    <div class="columns mb-0 is-mobile">
                        <div class="column is-3-desktop is-4-mobile info-title">Address</div>
                        <div class="column">East Cikarang, Bekasi, Indonesia 17825</div>
                    </div>
                    <div class="columns is-mobile">
                        <div class="column is-3-desktop is-4-mobile info-title">Social</div>
                        <div class="column is-narrow"><a href="https://linkedin.com/in/dendyaziz" target="_blank">
                            <b-icon pack="fab" icon="linkedin-in" size="is-small"></b-icon>
                        </a></div>
                        <div class="column is-narrow"><a href="https://instagram.com/dendyaziz" target="_blank">
                            <b-icon pack="fab" icon="instagram" size="is-small"></b-icon>
                        </a></div>
                        <div class="column is-narrow"><a href="https://github.com/dendyaziz" target="_blank">
                            <b-icon pack="fab" icon="github" size="is-small"></b-icon>
                        </a></div>
                        <div class="column is-narrow"><a href="https://dribbble.com/dendyaziz" target="_blank">
                            <b-icon pack="fab" icon="dribbble" size="is-small"></b-icon>
                        </a></div>
                    </div>
                    <div class="columns mt-3">
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
        <hr class="separator">
        <div class="container">
            <div class="columns py-2">
                <div class="column is-one-thirds">
                    <h1 class="has-text-weight-semibold mb-2"><span class="point">Skills</span></h1>
                    <h4 class="mb-4">I am inspired by creating great work with people who are as passionate as I am
                        about building something awesome.</h4>
                    <div class="wave is-hidden-touch">
                        <div class="zigzag">
                            <b-icon pack="fas" icon="chevron-down" size="is-medium" type="is-light"></b-icon>
                            <b-icon pack="fas" icon="chevron-down" size="is-medium" type="is-light"></b-icon>
                            <b-icon pack="fas" icon="chevron-down" size="is-medium" type="is-light"></b-icon>
                            <b-icon pack="fas" icon="chevron-down" size="is-medium" type="is-light"></b-icon>
                        </div>
                        <div class="zigzag">
                            <b-icon pack="fas" icon="chevron-down" size="is-medium" type="is-primary"></b-icon>
                            <b-icon pack="fas" icon="chevron-down" size="is-medium" type="is-primary"></b-icon>
                            <b-icon pack="fas" icon="chevron-down" size="is-medium" type="is-primary"></b-icon>
                            <b-icon pack="fas" icon="chevron-down" size="is-medium" type="is-primary"></b-icon>
                        </div>
                    </div>
                </div>
                <div class="column is-two-thirds">
                    <div class="columns py-2 is-multiline">
                        <div class="column is-half py-0">
                            <h3 class="has-text-weight-semibold mb-2">Skill 1</h3>
                            <h4>I am inspired by creating great work with people who are as passionate as I
                                am</h4>
                        </div>
                        <div class="column is-half py-0">
                            <hr class="is-hidden-tablet">
                            <h3 class="has-text-weight-semibold mb-2">Skill 2</h3>
                            <h4>I am inspired by creating great work with people who are as passionate as I
                                am about building something awesome.</h4>
                        </div>
                        <div class="column is-half py-0">
                            <hr>
                            <h3 class="has-text-weight-semibold mb-2">Skill 3</h3>
                            <h4>I am inspired by creating great work with people who are as passionate as I
                                am about building something awesome.</h4>
                        </div>
                        <div class="column is-half py-0">
                            <hr>
                            <h3 class="has-text-weight-semibold mb-2">Skill 4</h3>
                            <h4>I am inspired by creating great work with people who are as passionate as I
                                am</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>

    import Navbar from "../layouts/Navbar";
    import BIcon from "buefy/src/components/icon/Icon";

    export default {
        components: {BIcon, Navbar},
        data() {
            return {}
        }
    }
</script>
