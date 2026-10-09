# Movie Filters and Navigation

## Q1

The Movies list already has one route, and adding filters did not change the page's path. Laravel's router matches the path, such as `/movies`, not the query string after `?`. The controller reads `genre` and `year` from that query string, so the same route can handle either filter, both, or neither.

## Q2

If course and year were both route parameters, their values would occupy positions in the path. With a route like `/students/{course}/{year}`, a year-only URL would need an empty course position, conceptually `/students//4`, which is not a useful URL and normally will not match. Query strings avoid that problem: a year-only filter can simply be `/students?year=4`.

## Q3

The detail page needed the pattern to cover more than the exact `/movies` path, so I used `movies/*` to include paths such as `/movies/1`. A filter is attached to `/movies` as a query string, not another path segment. Since the path stays `/movies`, no extra pattern was needed for filters.

## Q4

The old filter method was removed because its behavior has been replaced by the query-filtered index, and the old URL now redirects there. Keeping the old method would leave a second, unused implementation. The empty `store` and `update` methods are unfinished resource actions reserved for future work, so they remain as placeholders.

# Movie Creation

## Q1

The form uses POST because it is creating a movie and should send the new record as a submission, not as part of a URL. If it used GET, the movie fields would be added to the address, where they could be bookmarked or repeated by revisiting that URL. Refreshing a GET result repeats the request, while the app's POST is followed by a redirect to the movie detail page, so refresh reloads that page instead of saving the form again.

## Q2

Laravel's `$request->validate()` checks the submitted fields before the save code runs. If a rule fails, validation automatically redirects back to the form and puts the errors and old input in the session. Because validation does not return validated data on failure, execution stops before the JSON file is written.

## Q3

The controller attaches the success message to the redirect as flash data in the session. Flash data is available for the next request only, and the shared layout displays it if it exists. The layout still renders on later pages, but the message has already been consumed, so it appears just once.
