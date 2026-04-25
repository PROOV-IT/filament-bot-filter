# Widgets

The plugin ships with:

- `BotProbeStatsWidget`
- `BotProbeTrendWidget`
- `BotProbeTopPathsWidget`

They all rely on the core `bot_probes` table and can be replaced by your own widgets if needed.

Widget visibility is controlled by the runtime settings page. If `show_widgets` is disabled there, the plugin will not register the dashboard widgets in the panel.

The bot probe table now also exposes bulk classification actions and saved views. These are not widgets, but they are designed to work together with the dashboard overview so operators can inspect the trend, then jump into a saved investigation preset, then classify incidents in bulk.
