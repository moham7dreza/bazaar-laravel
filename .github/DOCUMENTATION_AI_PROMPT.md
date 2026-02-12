# AI Documentation Generation Prompt

## Instructions for Developers

Copy the prompt below and paste it into your AI assistant (GitHub Copilot, Claude, ChatGPT, etc.) after completing your task. The AI will analyze your code changes and generate comprehensive documentation.

---

## 🤖 PROMPT START

I need you to generate comprehensive task documentation for the feature/task I just completed. Please analyze the recent code changes in my working directory and create documentation following this structure:

### Context
- **Project**: Laravel 12 Property Rental Platform
- **Branch Name**: [PASTE YOUR BRANCH NAME HERE - e.g., feature/BACKEND-100-implement-order]
- **Jira Ticket**: [PASTE JIRA TICKET NUMBER - e.g., BACKEND-100]
- **Jira Link**: [PASTE FULL JIRA URL]

### What I Need

Generate a Markdown documentation file that follows our standardized template with these sections:

1. **Metadata Section**
   - Extract Jira ticket number from branch name
   - Include branch name, task type, module, priority
   - List all new/modified backend routes
   - Include spaces for Confluence and API doc links

2. **Business Context** (MOST IMPORTANT - 70% focus)
   - What business problem does this solve?
   - Who are the affected users/stakeholders?
   - What business rules were implemented?
   - Write this section so a non-technical product manager can understand

3. **User Workflows**
   - Primary user flow (step-by-step)
   - Alternative flows
   - Error scenarios and how users experience them

4. **Technical Implementation** (30% focus)
   - List all backend routes (method, path, description, auth)
   - Key files created/modified
   - Database changes (high-level)
   - Integration points with other modules
   - Key validation rules

5. **Testing**
   - What test files were created?
   - What scenarios are covered?
   - Command to run the tests

6. **Security Considerations**
   - Authorization checks
   - Validation approach
   - Security measures implemented

7. **Performance Considerations**
   - Query optimization (eager loading, etc.)
   - Caching strategy
   - Database indexes
   - Expected load

8. **Deployment Notes**
   - New environment variables (if any)
   - Configuration changes
   - Migration commands
   - Rollback strategy

9. **Related Documentation**
   - Suggest related documentation files that might exist
   - Link to API documentation
   - Confluence page reference

10. **Known Issues/Limitations**
    - Current limitations
    - Future enhancements needed

### Analysis Instructions

Please analyze:
1. **Git Changes**: Look at my recent commits and changed files
2. **New Routes**: Identify any routes added to `routes/api.php`, `routes/web.php`, etc.
3. **Controllers**: New or modified controllers in `app/Http/Controllers/`
4. **Models**: New or modified Eloquent models in `app/Models/`
5. **Migrations**: New database migrations in `database/migrations/`
6. **Requests**: Form Request validation classes in `app/Http/Requests/`
7. **Tests**: New test files in `tests/Feature/` or `tests/Unit/`
8. **Services**: Any service classes created/modified

### Output Format

Generate the documentation in Markdown format following the template structure at `docs/templates/TASK_DOCUMENTATION_TEMPLATE.md`.

File should be saved as: `docs/features/[JIRA-TICKET]-[kebab-case-description].md`

### Important Guidelines

- **Language**: Use English for technical terms, but write business context clearly
- **Tone**: Professional but accessible
- **Focus**: 70% business value, 30% technical details
- **Completeness**: Include all required sections, mark optional sections clearly
- **Examples**: Provide concrete examples in business rules and workflows
- **Links**: Leave placeholder for links I need to fill in manually (Confluence, etc.)

### What NOT to Include

- Don't include full code snippets (only key validation rules or small examples)
- Don't go into excessive technical detail
- Don't assume the reader knows our internal systems
- Don't skip the business context - it's the most important part

### Special Instructions

If you cannot find certain information from the code:
- Mark it with [TODO: Fill this in]
- Add a comment explaining what information is needed

Generate the documentation now based on my recent code changes.

## 🤖 PROMPT END

---

## Post-Generation Checklist

After the AI generates your documentation:

1. [ ] Review the generated content for accuracy
2. [ ] Fill in any [TODO] placeholders
3. [ ] Add Confluence documentation link (if PM provided one)
4. [ ] Add API documentation link (if applicable)
5. [ ] Verify business context makes sense to non-technical readers
6. [ ] Ensure all routes and files are correctly listed
7. [ ] Save the file with correct naming: `docs/features/JIRA-XXX-description.md`
8. [ ] Add and commit the documentation with your code changes

```bash
git add docs/features/[your-doc-file].md
git commit -m "docs: add documentation for [JIRA-XXX]"
```

---

## Troubleshooting

**Q: The AI doesn't have access to my code changes**
A: Make sure you're using an AI assistant integrated with your IDE (like GitHub Copilot in VSCode/JetBrains) that can see your workspace.

**Q: The AI generated incorrect information**
A: Review and correct manually. The AI is a starting point, not a replacement for your judgment.

**Q: Can I customize the prompt?**
A: Yes! Add specific context about your task if needed, but maintain the core structure.

**Q: Should I use this for small bug fixes?**
A: For very small fixes, you can use a simplified version. Consult with your team lead.

---

## Alternative: Quick Prompt (For Simple Tasks)

For smaller tasks, use this condensed prompt:

```
Generate task documentation for my Laravel feature following our template at docs/templates/TASK_DOCUMENTATION_TEMPLATE.md.

Branch: [YOUR-BRANCH]
Jira: [JIRA-TICKET]

Focus on:
- Business problem solved
- User impact
- Routes added/modified
- Key files changed
- Tests created

Output as Markdown in docs/features/[JIRA-XXX]-[description].md
```

---

*Last Updated: 2026-01-02*

