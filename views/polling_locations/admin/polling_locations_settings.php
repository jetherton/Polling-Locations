<table style="width: 630px;" class="my_table">

	<tr>

		<td>

			<h4><?=Kohana::lang('pollinglocation.description')?> </h4>
			<div class="row">
				<h4><?php print form::label('election_id', 'Election Id'); ?></h4>
				<?php print form::input('election_id', $form['election_id'], ' class="text title_2"'); ?>
			</div>

			<div class="row">
				<h4><?php print form::label('api_key', 'API Key'); ?></h4>
				<p>Follow the instructions at <a href="https://developers.google.com/civic-information/docs/using_api#APIKey">Google Civic Information API</a> to get an API key.</p>
				<?php print form::input('api_key', $form['api_key'], ' class="text title_2"'); ?>
			</div>

			<div class="row">
				<h4><?php print form::label('address_selector', 'Address Selector'); ?></h4>
				<p>jQuery selector for the address input. Ex. input[name='state']</p>
				<?php print form::input('address_selector', $form['address_selector'], ' class="text title_2"'); ?>
			</div>

			<div class="row">
				<h4><?php print form::label('city_selector', 'City Selector'); ?></h4>
				<p>jQuery selector for the city input. Ex. input[name='city']</p>
				<?php print form::input('city_selector', $form['city_selector'], ' class="text title_2"'); ?>
			</div>

			<div class="row">
				<h4><?php print form::label('state_selector', 'State Selector'); ?></h4>
				<p>jQuery selector for the state input or select. Ex. input[name='state']</p>
				<?php print form::input('state_selector', $form['state_selector'], ' class="text title_2"'); ?>
			</div>

			<div class="row">
				<h4><?php print form::label('zip_selector', 'Zip Code Selector'); ?></h4>
				<p>jQuery selector for the zip code input. Ex. input[name='zip']</p>
				<?php print form::input('zip_selector', $form['zip_selector'], ' class="text title_2"'); ?>
			</div>

			<div class="row">
				<h4><?php print form::label('button_placement', 'Button Placement Selector'); ?></h4>
				<p>jQuery selector for where to appended the button.</p>
				<?php print form::input('button_placement', $form['button_placement'], ' class="text title_2"'); ?>
			</div>


			<div class="row">
				<h4><?php print form::label('button_selector', 'Button Selector'); ?></h4>
				<p>jQuery selector for the button. Ex. button[name='location']</p>
				<?php print form::input('button_selector', $form['button_selector'], ' class="text title_2"'); ?>
			</div>

			<div class="row">
				<h4><?php print form::label('info_box_selector', 'Results Container Selector'); ?></h4>
				<p>jQuery selector for the results containter. Ex. #locations</p>
				<?php print form::input('info_box_selector', $form['info_box_selector'], ' class="text title_2"'); ?>
			</div>

			<div class="row">
				<h4><?php print form::label('error_message', 'Error Message'); ?></h4>
				<p>error message for when no locations are found.</p>
				<?php print form::input('error_message', $form['error_message'], ' class="text title_2"'); ?>
			</div>
			
		</td>


	</tr>

</table>
