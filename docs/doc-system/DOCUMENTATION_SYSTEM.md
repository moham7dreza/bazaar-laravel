# Documentation System Implementation Guide

## Overview

This document outlines the comprehensive documentation system for our Laravel 12 property rental platform. The system enforces documentation creation for every task through automated validation and provides multiple pathways for developers to create documentation.

## Problem Statement

After 10 years of development, we need:
- Business-focused documentation (~100 pages) for new product managers and backend developers
- Mandatory documentation for every task/feature
- Consistent structure across all documentation
- Easy discoverability and searchability
- Integration with Jira, Confluence, and our CI/CD pipeline

## Industry Best Practices Research

### How Major Companies Handle Documentation

1. **Stripe** - Docs-as-Code approach with automated validation
2. **Airbnb** - RFC (Request for Comments) process for significant changes
3. **Spotify** - Backstage TechDocs with Markdown and MkDocs
4. **Microsoft** - Automated documentation generation with mandatory PR checks
5. **Google** - Design docs required before implementation

### Common Patterns

- **Documentation-as-Code**: Documentation lives in the repository alongside code
- **Template-driven**: Consistent templates ensure structure
- **Automated Validation**: CI/CD enforces documentation existence
- **Searchable Interface**: Central hub for all documentation
- **Metadata Linking**: Automatic linking to Jira, PRs, Confluence

## Proposed Solution Architecture

### 1. Documentation Structure

```
docs/
├── features/           # Feature documentation
│   ├── BACKEND-100-implement-order.md
│   └── BACKEND-101-payment-gateway.md
├── business/          # Business logic documentation
├── architecture/      # System architecture
├── patterns/          # Design patterns used
└── templates/         # Documentation templates
```

### 2. Metadata Standard

Every documentation file MUST include:

**Required Fields:**
- Jira ticket link
- Branch name
- Task title
- Feature/change description
- Backend routes (if applicable)
- Business impact
- Author information
- Date created

**Optional Fields:**
- Confluence documentation link
- API documentation link
- Related documentation links
- Database schema changes
- External dependencies

### 3. Implementation Components

#### A. Documentation Template (Markdown)
A standardized template that all docs must follow.

#### B. Artisan Console Command
`php artisan make:task-doc` - Interactive command using Laravel Prompts for developers without AI.

#### C. AI Prompt Template
Standardized prompt for GitHub Copilot/AI assistants that generates documentation automatically.

#### D. Validation Test
Pest test that fails if documentation doesn't exist for the current branch.

#### E. CI/CD Integration
- GitHub Actions workflow validation
- Telegram notification on merge/deployment
- Optional: Confluence API integration

#### F. Documentation Viewer
Laravel route with search functionality to browse all documentation.

## Technical Implementation Details

### Documentation File Naming Convention

Format: `{JIRA-TICKET}-{kebab-case-description}.md`

Example: `BACKEND-100-implement-order-processing.md`

### Documentation Structure Template

See `docs/templates/TASK_DOCUMENTATION_TEMPLATE.md`

### Technical vs Business Balance

**Business Focus (70%):**
- What problem does this solve?
- How does it impact users?
- What business rules are implemented?
- User workflows and scenarios

**Technical Details (30%):**
- Key routes/endpoints
- Database changes (high-level)
- Integration points
- Performance considerations

### Enforcement Strategy

1. **Pre-commit Hook**: Warn about missing documentation
2. **CI/CD Validation**: Fail build if documentation missing
3. **PR Template**: Checklist item for documentation
4. **Code Review**: Reviewers verify documentation quality

### Searchability & Discovery

**Option 1: In-App Documentation Viewer (Recommended)**
- Laravel route with Markdown parser
- Full-text search using Laravel Scout + Meilisearch/Algolia
- Filter by date, author, Jira ticket, module
- Mobile-friendly interface

**Option 2: Confluence API Integration**
- Automatically sync docs to Confluence after merge
- Maintain bidirectional linking
- Requires Confluence REST API access

**Option 3: Hybrid Approach**
- Primary: In-app viewer for developers
- Secondary: Confluence sync for product team

### Telegram Notification Format

```
🚀 Feature Deployed: BACKEND-100

📝 Implement Order Processing
🔗 Documentation: {URL}
🎫 Jira: {JIRA_URL}
🌿 Branch: feature/BACKEND-100-implement-order
👤 Author: @developer_username
📅 Deployed: 2026-01-02 14:30 UTC

View full documentation: {DOC_VIEWER_URL}
```

## Workflow for Developers

### Workflow 1: Using AI (Recommended)

1. Complete your feature/task
2. Copy AI prompt from `.github/documentation-prompt.md`
3. Paste in GitHub Copilot chat in your IDE
4. AI generates documentation based on code changes
5. Review and adjust if needed
6. Save to `docs/features/`
7. Commit with feature code

### Workflow 2: Manual Creation

1. Complete your feature/task
2. Run: `php artisan make:task-doc`
3. Answer interactive prompts (Laravel Prompts)
4. Documentation file created automatically
5. Fill in additional details
6. Commit with feature code

### Workflow 3: Template-based

1. Copy `docs/templates/TASK_DOCUMENTATION_TEMPLATE.md`
2. Rename following convention
3. Fill in all sections
4. Commit with feature code

## Success Metrics

- **Documentation Coverage**: 100% of merged features have documentation
- **Time to Document**: <10 minutes per task
- **Documentation Quality**: Reviewed in PR process
- **Developer Satisfaction**: Minimal friction, maximum value
- **Onboarding Time**: 50% reduction for new developers

## Rollout Plan

### Phase 1: Foundation (Week 1)
- Create templates
- Implement Artisan command
- Create AI prompt
- Document existing major features

### Phase 2: Enforcement (Week 2)
- Add documentation validation test
- Update CI/CD pipeline
- Create PR template with documentation checklist

### Phase 3: Discovery (Week 3)
- Build documentation viewer
- Implement search functionality
- Add Telegram notifications

### Phase 4: Refinement (Week 4)
- Gather developer feedback
- Refine templates
- Optional: Confluence integration

## Frequently Asked Questions

**Q: What if a task is too small to document?**
A: All tasks in Jira should have minimal documentation. Very small fixes can use a simplified template.

**Q: What language should documentation be in?**
A: Business documentation in Persian for product team, technical details can be in English.

**Q: How do we handle documentation for old features?**
A: Create documentation gradually as features are modified, or dedicate sprint for legacy docs.

**Q: What if documentation becomes outdated?**
A: When modifying a feature, developers must update its documentation as part of the task.

## Next Steps

1. Review and approve this proposal
2. Create documentation templates
3. Implement Artisan command
4. Create AI prompt template
5. Add validation tests
6. Update CI/CD pipeline
7. Train team on new workflow

## References

- [Google Engineering Practices - Design Docs](https://google.github.io/eng-practices/)
- [Spotify Backstage TechDocs](https://backstage.io/docs/features/techdocs/techdocs-overview)
- [Stripe Documentation Best Practices](https://stripe.com/docs)
- [The Documentation System](https://documentation.divio.com/)

