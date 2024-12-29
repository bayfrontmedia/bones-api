# Events: ScheduledJobs

Scheduled jobs.

| Subscription (method)         | Event     | Priority |
|-------------------------------|-----------|----------|
| [scheduleJobs](#schedulejobs) | `app.cli` | 10       |

## scheduleJobs

**Description:**

Add scheduled jobs to scheduler. Scheduled jobs include:

- `delete-expired-buckets`: All buckets not updated in more than 1 hour are deleted. This job is run every 15 minutes.

**Parameters:**

- (none)

**Returns:**

- (void)

**Throws:**

- `Bayfront\CronScheduler\LabelExistsException`
- `Bayfront\CronScheduler\SyntaxException`