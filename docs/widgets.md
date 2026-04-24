# Widgets

The plugin ships with:

- `BotProbeStatsWidget`
- `BotProbeTrendWidget`
- `BotProbeTopPathsWidget`

They all rely on the core `bot_probes` table and can be replaced by your own widgets if needed.

Widget visibility is controlled by the runtime settings page. If `show_widgets` is disabled there, the plugin will not register the dashboard widgets in the panel.
