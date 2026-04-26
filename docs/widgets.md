# Widgets

The plugin ships with:

- `UrlWatchStatsWidget`
- `UrlWatchTrendWidget`
- `UrlWatchTopPathsWidget`
- `UrlWatchTopHostsWidget`

They all rely on the core `url_watches` table and can be replaced by your own widgets if needed.
The trend and top-path charts also benefit from the detailed `url_watch_events` history table.

Widget visibility is controlled by the runtime settings page. If `show_widgets` is disabled there, the plugin will not register the dashboard widgets in the panel.

The URL watch table now also exposes bulk classification actions, built-in operator presets, and saved views. These are not widgets, but they are designed to work together with the dashboard overview so operators can inspect the trend, jump into a system preset like "Pending review" or "Recent 404s", then save a custom view for their own workflow.

Widgets now support direct drill-down:

- stats cards open the most relevant list view
- top paths bars open the event history with a pre-filled search
- top hosts bars open the event history filtered by host search
- trend points open the event history for the selected day

Operator presets are also context-aware. For example, an admin panel can expose admin-only presets without cluttering manager or B2B panels with irrelevant options.
