<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://brino.sk
 * @since      1.0.0
 *
 * @package    Brino_Sync
 * @subpackage Brino_Sync/admin/partials
 */
?>

<?php
function storeApiKey()
{
    update_option('brinnoApikey', $_POST['brinnoApikey']);
}

if (isset($_POST['submit']) && isset($_POST['brinnoApikey'])) {
    storeApiKey();
}
?>


<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="p-5 mb-4 bg-light rounded-3">
    <h1>Sync your products, categories, tags and posts</h1>
    <form id="brino-sync-form__form" method="post">
        <?php
        settings_fields("brinocustomsettings");
        do_settings_sections("brinocustomsettings");
        ?>
        <div class="form-group mb-2">
            <label for="apiKeyInput">API key</label>
            <input type="text" value="<?php echo get_option('brinnoApikey'); ?>" name='brinnoApikey'
                placeholder="Brino's api key" class="form-control">
        </div>
        <button type="submit" value="click" name="submit" class="btn btn-primary btn-block w-100">Save</button>
    </form>
</div>