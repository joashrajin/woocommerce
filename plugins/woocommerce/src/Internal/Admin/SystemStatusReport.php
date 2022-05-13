<?php
/**
 * Add additional system status report sections.
 */

namespace Automattic\WooCommerce\Internal\Admin;

use Automattic\WooCommerce\Admin\Features\Features;

defined( 'ABSPATH' ) || exit;

/**
 * SystemStatusReport class.
 */
class SystemStatusReport {
	/**
	 * Class instance.
	 *
	 * @var SystemStatus instance
	 */
	protected static $instance = null;

	/**
	 * Get class instance.
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Hook into WooCommerce.
	 */
	public function __construct() {
		add_action( 'woocommerce_system_status_report', array( $this, 'system_status_report' ) );

	}

	/**
	 * Hooks extra necessary sections into the system status report template
	 */
	public function system_status_report() {
		$this->render_features();
	}

	/**
	 * Render system status report Features section.
	 */
	public function render_features() {
		/**
		 * Filter the admin feature configs.
		 *
		 * @since 6.5.0
		 */
		$features = apply_filters( 'woocommerce_admin_get_feature_config', wc_admin_get_feature_config() );

		?>
			<table class="wc_status_table widefat" cellspacing="0">
				<thead>
				<tr>
					<th colspan="5" data-export-label="Features"><h2><?php esc_html_e( 'Features', 'woocommerce' ); ?><?php echo wc_help_tip( esc_html__( 'This section shows details of features.', 'woocommerce' ) ); ?></h2></th>
				</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $features as $feature => $is_enabled ) {
						printf(
							'<tr>
								<td>%1$s</td>
								<td>%2$s</td>
							</tr>',
							esc_html( $feature ),
							esc_html( $is_enabled ? 'true' : 'false' )
						);
					}
					?>
				</tbody>
			</table>
		<?php
	}

}
