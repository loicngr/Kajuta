<?php
/**
 * Fournir une vue du back-office pour le plugin
 *
 * @since      1.0.0
 *
 * @package    Kajuta_Shelter
 * @subpackage Kajuta_Shelter/admin/partials
 */

// Si l'utilisateur possède bien les droits
if (!current_user_can('manage_options')) {
    return;
} ?>
<div class="container">
	<h3>
		<?php esc_html_e('List', 'kajuta_shelter'); ?>
	</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td colspan="2">Larry the Bird</td>
                <td>@twitter</td>
            </tr>
            </tbody>
        </table>
    </div>

</div>
