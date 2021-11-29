<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php

$success ='';
if( isset( $_POST[ 'books_per_page' ] ) && isset( $_POST[ 'currency' ] ) ) {
    update_option( 'books_per_page', $_POST[ 'books_per_page' ] );
    update_option( 'currency', $_POST[ 'currency' ] );
    $success = 'success';
}

$currency = get_option( 'currency');

?>

<div class="wrap">
    <h1>BooksMenu</h1>
    <?php if( $success == 'success' ) {?>
        <div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible"> 
            <p>
                <strong>Settings saved.</strong>
            </p>
        </div>
    <?php } ?>
    <form method="post" action= "<?php echo get_admin_url( )."options-general.php?page=books_menu" ?>" novalidate="novalidate">
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row">
                    <label for="books_per_page">Books per Page</label>
                </th>
                <td>
                    <input name="books_per_page" id="books_per_page" value="<?php echo get_option( 'books_per_page' ) ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="currency">Currency</label>
                </th>
                <td>
                    <fieldset>
                        <label>
                            <input type="radio" name="currency" value="rs" <?php echo $currency == 'rs'? 'checked':'' ?> />
                            <span>RS</span>
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="currency" value="usd" <?php echo $currency == 'usd'? 'checked':'' ?> />
                            <span>USD</span>
                        </label>
                        <br>
                    </fieldset>
                </td>
            </tr>
        </table>
        <?php submit_button( 'Save Settings' );?>
    </form> 
</div>