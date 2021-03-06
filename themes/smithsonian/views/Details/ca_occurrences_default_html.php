<?php
	$t_occurrence = $this->getVar("item");

	$va_comments = $this->getVar("comments");
?>
<div class="row">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row"><div class='col-md-12 col-lg-12'>
			<H4>{{{^ca_occurrences.preferred_labels.displayname}}}</H4>
			{{{<unit><ifdef code="ca_occurrences.nonpreferred_labels"><p>^ca_occurrences.nonpreferred_labels.displayname</p></ifdef></unit>}}}
			{{{<unit><ifdef code="ca_occurrences.idno"><p>ID: ^ca_occurrences.idno</p></ifdef></unit>}}}
<?php
			if ($t_occurrence->get('ca_occurrences.workType', array('excludeValues' => array('null'))) != "") {
				print "<p>Type: ".$t_occurrence->get('ca_occurrences.workType', array('convertCodesToDisplayText' => true, 'excludeValues' => array('null')))."</p>";
			}	
?>			
			{{{<ifcount min="1" code="ca_occurrences.workDate.dates_value" ><p>Date: <unit delimiter=", ">^ca_occurrences.workDate.dates_value <ifcount min="1" code="ca_occurrences.workDate.work_dates_types">(^ca_occurrences.workDate.work_dates_types)</ifdef></unit></p></ifcount>}}}
			
			<hr>
			<h5>Rights & Permissions</h5>
			{{{<unit><ifdef code="ca_occurrences.restrictions"><div><span class='metaTitle'>Restrictions</span><span class='meta'>^ca_occurrences.restrictions</span></div></ifdef></unit>}}}
			{{{<unit><ifdef code="ca_occurrences.rights"><div><span class='metaTitle'>Rights</span><span class='meta'>^ca_occurrences.rights</span></div></ifdef></unit>}}}
<?php
			if ($t_occurrence->get('ca_occurrences.sniDepiction', array('excludeValues' => array('not_specified'))) != "") {
				print "<div><span class='metaTitle'>Depicts SNI</span><span class='meta'>".$t_occurrence->get('ca_occurrences.sniDepiction', array('convertCodesToDisplayText' => true, 'excludeValues' => array('not_specified')))."</span></div>";
			}	
			if ($va_contributors = $t_occurrence->get('ca_entities', array('excludeRelationshipTypes' => array('subject, interviewee'), 'returnAsArray' => true))) {
				print "<div><span class='metaTitle'>Contributors</span><div class='meta'>";
				foreach ($va_contributors as $cont_key => $va_contributor) {
					print "<div>".caNavLink($this->request, $va_contributor['displayname']." (".$va_contributor['relationship_typename'].")", '' , 'Detail', 'entities', $va_contributor['entity_id'])."</div>";
				}
				print "</div></div>";
			}	
?>
			<hr>
			<h5>Content</h5>
			
			{{{<ifcount code="ca_occurrences.description" min="1"><span class='metaTitle'>Description</span><span class='meta'>^ca_occurrences.description</span></ifcount>}}}
			
			{{{<ifcount code="ca_places" min="1" max="1"><span class='metaTitle'>Related Place</span></ifcount>}}}
			{{{<ifcount code="ca_places" min="2"><span class='metaTitle'>Related Places</span></ifcount>}}}
			{{{<ifcount code="ca_places.preferred_labels" min="1"><unit relativeTo="ca_places" delimiter="<br/>"><l><div class='meta'>^ca_places.preferred_labels</div></l></unit></ifcount>}}}

			{{{<ifcount code="ca_entities" min="1" max="1"><span class='metaTitle'>Related Entity</span></ifcount>}}}
			{{{<ifcount code="ca_entities" min="2"><span class='metaTitle'>Related Entities</span></ifcount>}}}
			{{{<ifcount code="ca_entities.preferred_labels" min="1"><unit relativeTo="ca_entities" delimiter="<br/>"><l><div class='meta'>^ca_entities.preferred_labels</div></l></unit></ifcount>}}}
			
			{{{<ifcount code="ca_occurrences.lcsh_names" min="1"><span class='metaTitle'>LCSH Names</span></ifcount>}}}
			{{{<ifcount code="ca_occurrences.lcsh_names" min="1"><span class='meta'><unit delimiter=" "><div>^ca_occurrences.lcsh_names</div></unit></span></ifcount>}}}
			
			{{{<ifcount code="ca_occurrences.lcsh_subjects" min="1"><span class='metaTitle'>LCSH Subjects</span></ifcount>}}}
			{{{<ifcount code="ca_occurrences.lcsh_names" min="1"><span class='meta'><unit delimiter=" "><div>^ca_occurrences.lcsh_subjects</div></unit></span></ifcount>}}}
			
			<hr>
			<h5>Program Info</h5>
<?php
			if ($t_occurrence->get('ca_occurrences.workDate.work_dates_types') == "First air date") {
				print "<div><span class='metaTitle'>Air Date</span><span class='meta'>".$t_occurrence->get('ca_occurrences.workDate.dates_value')."</span></div>";
			}
			if ($t_occurrence->get('ca_occurrences.genre') != "") {
				print "<div><span class='metaTitle'>Genre</span><span class='meta'>".$t_occurrence->get('ca_occurrences.genre')."</span></div>";
			}	
			if ($t_occurrence->get('ca_occurrences.productionTypes') != "") {
				print "<div><span class='metaTitle'>Production type</span><span class='meta'>".$t_occurrence->get('ca_occurrences.productionTypes')."</span></div>";
			}
			if ($t_occurrence->get('ca_occurrences.mission.missionCritical') == "Yes") {
				print "<div><span class='metaTitle'>Mission critical</span><span class='meta'><div>Mission Critical: ".$t_occurrence->get('ca_occurrences.mission.missionCritical')."</div>";
				print "<div>Year: ".$t_occurrence->get('ca_occurrences.mission.missionYear')." (".$t_occurrence->get('ca_occurrences.mission.mission_dates_types').")</div>";
				print "</span></div>";
			}
			$va_awards = $t_occurrence->get('ca_occurrences.awards', array('returnAsArray' => true));
			if (sizeof($va_awards) > 0) {
				print "<div><span class='metaTitle'>Awards</span><span class='meta'>";
				foreach ($va_awards as $award => $va_award) {
					print "<div>Award: ".$va_award['award_event']."</div>";
					print "<div>Year: ".$va_award['award_year']."</div>";
					print "<div>Type: ".$va_award['award_types']."</div>";
					print "<div>Notes: ".$va_award['award_notes']."</div>";
					print "<div style='height:10px;'></div>";
				}
				print "</span></div>";
			}
													
?>			
		{{{<ifcount code="ca_occurrences.distribution_status.distribution_date" min="1"><span class='metaTitle'>Distribution Status</span></ifcount>}}}
			{{{<ifcount code="ca_occurrences.distribution_status.distribution_date" min="1"><span class='meta'><unit delimiter="<br/>"><div>^ca_occurrences.distribution_status.distribution_list, Expires ^ca_occurrences.distribution_status.distribution_date</div></unit></span></ifcount>}}}									
		
		{{{<ifcount code="ca_objects" min="2">
			<div id="detailRelatedObjects">
				<H6>Related Objects <a href="#">view all</a></H6>
				<div class="jcarousel-wrapper">
					<div id="detailScrollButtonNext"><i class="fa fa-angle-right"></i></div>
					<div id="detailScrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
					<!-- Carousel -->
					<div class="jcarousel">
						<ul>
							<unit relativeTo="ca_objects" delimiter=" "><li><div class='detailObjectsResult'><l>^ca_object_representations.media.widepreview</l><br/><l>^ca_objects.preferred_labels.name</l></div></li><!-- end detailObjectsBlockResult --></unit>
						</ul>
					</div><!-- end jcarousel -->
					
				</div><!-- end jcarousel-wrapper -->
			</div><!-- end detailRelatedObjects -->
			<script type='text/javascript'>
				jQuery(document).ready(function() {
					/*
					Carousel initialization
					*/
					$('.jcarousel')
						.jcarousel({
							// Options go here
						});
			
					/*
					 Prev control initialization
					 */
					$('#detailScrollButtonPrevious')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '-=1'
						});
			
					/*
					 Next control initialization
					 */
					$('#detailScrollButtonNext')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '+=1'
						});
				});
			</script></ifcount>}}}
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			
			<div class='col-md-6 col-lg-6'>
				{{{<ifdef code="ca_occurrences.notes"><H6>About</H6>^ca_occurrences.notes<br/></ifdef>}}}
				
				

			</div><!-- end col -->
			<div class='col-md-6 col-lg-6'>
				{{{<ifcount code="ca_objects" min="1" max="1"><H6>Related object</H6><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.media.small</l><br/><l>^ca_objects.preferred_labels.name</l><br/></unit></ifcount>}}}
				

			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->