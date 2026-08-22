# GestorDB

### Schema-aware automatic CRUD · PHP/MySQL · Metadata-driven interfaces · AI-assisted development

GestorDB is an experimental PHP database abstraction and automatic CRUD system designed around a central idea: **the database schema itself can provide enough metadata for an application to construct much of its interface and behavior dynamically.**

The project evolved from earlier experiments in automatic code generation into a more dynamic approach developed with the assistance of generative AI.

Rather than writing a separate CRUD implementation for every table, GestorDB inspects the real MySQL schema at runtime and uses conventions, field metadata and relationships to determine how data should be displayed and manipulated.

---

## The problem

A conventional database application often repeats the same work for every entity:

```text
Table
  ├── list view
  ├── add form
  ├── edit form
  ├── delete action
  ├── search
  ├── validation
  └── relationships
```

Much of that information already exists in the database schema.

GestorDB explores the question:

> If the database already knows its fields, types, keys, defaults and relationships, how much of the CRUD application can be inferred automatically?

---

## Architecture

```text
                 MySQL Database
                       │
                       ▼
                 DESCRIBE table
                       │
                       ▼
        ┌──────────────────────────────┐
        │      Schema introspection    │
        │                              │
        │ field · type · null · key    │
        │ default · extra              │
        └──────────────┬───────────────┘
                       │
                       ▼
        ┌──────────────────────────────┐
        │     Convention inference     │
        │                              │
        │ visibility · references      │
        │ field behavior · details     │
        └──────────────┬───────────────┘
                       │
                       ▼
        ┌──────────────────────────────┐
        │       Dynamic rendering      │
        │                              │
        │ tables · forms · selects     │
        │ states · master/detail       │
        └──────────────┬───────────────┘
                       │
                       ▼
                CRUD application
```

---

## Schema introspection

The core `GestorDB` class queries MySQL with `DESCRIBE` and extracts metadata including:

- field name;
- SQL type;
- nullability;
- key information;
- default value; and
- extra attributes.

That metadata becomes input for application behavior rather than merely being documentation about the database.

Conceptually:

```text
Database structure → metadata → conventions → interface/CRUD behavior
```

This is the main architectural idea behind GestorDB.

---

## Convention-driven behavior

GestorDB experiments with conventions encoded directly into schema naming.

### Field visibility

Some generated views use capitalization conventions to decide which database fields should be presented to the user. This allows internal and visible fields to coexist in the same table while the renderer interprets their naming convention.

### Relationship inference

Fields following the `_id_` naming convention can be interpreted as references to another table.

The class can derive the probable related table, inspect it and retrieve values that can then be represented as selectable options instead of requiring every relationship control to be programmed manually.

### Master/detail structures

The implementation also explores table-detail conventions such as:

```text
<Table>
<Table>_Detalles
```

allowing related structures to participate in dynamically generated views.

---

## Dynamic views

GestorDB can construct HTML table views directly from database metadata and query results.

Instead of defining every column manually, the renderer discovers the available fields and applies the project's visibility conventions.

The implementation also contains presentation logic for semantic values such as `Estado`, translating values such as active, inactive, pending, in progress, delivered or cancelled into visual status indicators.

This demonstrates another aspect of the experiment: **data semantics can influence presentation automatically.**

---

## CRUD evolution

The repository preserves a `CRUD original/` directory containing an earlier implementation with explicit files for operations such as:

- add;
- view;
- edit;
- delete; and
- search.

That directory is useful historical evidence of the architectural evolution of the project.

The later `GestorDB.php` moves toward concentrating reusable behavior in a schema-aware class rather than reproducing the same implementation independently for each entity.

```text
Traditional CRUD
      │
      ▼
Repeated entity-specific files
      │
      ▼
Reusable CRUD logic
      │
      ▼
Schema-aware GestorDB
```

---

## From AutoPHP to GestorDB

GestorDB is particularly useful in the context of my earlier project **AutoPHP**.

AutoPHP approached automation primarily as code generation:

```text
Schema → deterministic rules → generated PHP files
```

GestorDB explores a more dynamic model:

```text
Schema → introspection → interpretation → reusable runtime behavior
```

The objective remained similar — eliminate predictable repetitive development — while the implementation strategy evolved.

---

## AI-assisted development

GestorDB was developed during the period in which generative AI became practical as a software-development assistant.

For me, this was not the beginning of automation. Earlier projects such as AutoPHP had already explored metadata-driven generation using deterministic rules.

Generative AI changed the development process by making it possible to iterate on those ideas with a system capable of working with code and context interactively.

GestorDB therefore represents an important transition in my work:

```text
Deterministic automation
        │
        ▼
Schema-driven systems
        │
        ▼
AI-assisted development
        │
        ▼
Context-aware AI systems and agents
```

That direction later continued into work involving LLM integrations, retrieval, persistent memory, agents and task orchestration.

---

## Repository structure

### `GestorDB.php`

Main schema-aware PHP class. It contains database introspection, dynamic rendering, relationship/convention handling and reusable database/application behavior.

### `dashboard.php`

Application/dashboard layer demonstrating use of the database management functionality.

### `db.php`

Database connection configuration used by the historical implementation.

### `CRUD original/`

Preserved earlier CRUD implementation showing the project's evolution from explicit operation-specific files toward reusable dynamic behavior.

### `gdair_store.sql`

Database structure/data used with the project and useful for understanding the schema conventions against which GestorDB was developed.

---

## What this repository demonstrates

From an engineering perspective, GestorDB is an experiment in:

- PHP backend development;
- MySQL schema introspection;
- automatic CRUD behavior;
- metadata-driven interfaces;
- convention over configuration;
- relationship inference;
- dynamic HTML generation;
- master/detail data structures;
- reusable database abstractions; and
- AI-assisted software development.

It is not simply a database connection class. Its more interesting purpose is to explore how **software can inspect an unfamiliar schema and adapt part of its behavior to that structure automatically.**

---

## Historical / security status

This repository documents an experimental stage of development and should not be treated as a current production framework without review and modernization.

Some SQL identifiers are dynamically constructed from schema/table names. Prepared statements cannot parameterize SQL identifiers in the same way as ordinary values, so a modern production implementation should explicitly validate or allow-list all dynamic identifiers.

A production rewrite should also use current PHP practices, environment-based secrets, strict validation, escaping/output encoding, CSRF protection where applicable, authorization controls, automated tests and clearly defined schema metadata rather than relying only on naming conventions.

The repository is valuable as an architectural and historical project, but its original code should be reviewed before deployment on an Internet-facing system.

---

## Technology

- PHP
- MySQL
- MySQLi
- SQL schema introspection
- HTML
- Dynamic UI generation
- Metadata-driven architecture
- AI-assisted development

---

## Related evolution

**AutoPHP** — schema-driven deterministic PHP code generation  
**GestorDB** — schema-aware dynamic CRUD and AI-assisted development  
**MiChat** — context, retrieval, memory, agents and persistent AI orchestration

These projects represent different generations of the same recurring engineering interest: **reducing repetitive human work by allowing software to derive useful behavior from structured information and context.**

---

## Author

**Jimmy Backend**  
Backend · Cloud · AI Systems

GitHub: **@jimmybackend**
