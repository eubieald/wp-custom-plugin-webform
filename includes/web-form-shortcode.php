<?php
if (!defined('ABSPATH')) {
    exit;
}

add_shortcode('mgroup-web-form', array('WebFormShortcode', 'load_shortcode'));

class WebFormShortcode {
    public static function load_shortcode() {
        ob_start(); // Start output buffering
        ?>
        <div class="form-wrapper">
            <p class="greetings">We'd love to help, leave us your details, and we'll be in touch.</p>
            <form id="web-form" class="web-form__form">
                <input type="hidden" name="_wpnonce" value="<?php echo esc_attr(wp_create_nonce('wp_rest')); ?>">

                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="web-form__input" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="web-form__input" required>

                <label for="phone">Phone number</label>
                <input type="tel" id="phone" name="phone" class="web-form__input">

                <label for="service-required">Service required</label>
                <select id="service-required" name="service-required" class="web-form__select" required>
                    <option value="">Select a service</option>
                    <option value="electricity">Electricity</option>
                    <option value="internet">Internet</option>
                    <option value="solar">Solar</option>
                </select>

                <button type="submit" class="web-form__submit">Submit</button>
            </form>
        </div>
        <?php
        return ob_get_clean(); // Return the buffered output
    }
}
