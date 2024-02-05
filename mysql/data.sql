create table
  `files` (
    `id` int unsigned not null auto_increment primary key,
    `created_at` timestamp not null default CURRENT_TIMESTAMP,
    `name` varchar(255) null,
    `parent_id` INTEGER UNSIGNED null,
  )
