<% if LatestTweets %>
	<ul class="Tweets">
		<% loop LatestTweets %>
			<li class="Tweet">$Content</li>
		<% end_loop %>
	</ul>
<% end_if %>
