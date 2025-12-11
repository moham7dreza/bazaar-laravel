# MCP Configuration Management - Makefile Commands

## Overview

A comprehensive set of Makefile commands to manage MCP (Model Context Protocol) configuration files for IntelliJ IDEA and VSCode GitHub Copilot integration.

## Quick Start

### Copy MCP Configuration to IntelliJ
```bash
make mcp-copy
```

### Copy to All IDEs
```bash
make mcp-copy-all
```

### View All Commands
```bash
make mcp-help
```

---

## Configuration Files

### Project Root
- **Source**: `mcp.json` (project root)
- Contains Laravel Boost MCP server configuration

### IntelliJ IDEA
- **Target**: `~/.config/github-copilot/intellij/mcp.json`
- Used by GitHub Copilot in IntelliJ IDEA

### VSCode
- **Target**: `~/.config/Code/User/globalStorage/github.copilot-chat/mcp.json`
- Used by GitHub Copilot in VSCode

---

## Available Commands

### 📋 Copy Commands

#### `make mcp-copy`
Copy `mcp.json` from project root to IntelliJ Copilot configuration directory.

**What it does:**
- Validates source file exists
- Creates target directory if needed
- Copies file with verbose output
- Shows success message with target path

**Example output:**
```
▶ Copying MCP configuration to IntelliJ...
'mcp.json' -> '/home/user/.config/github-copilot/intellij/mcp.json'
✓ MCP configuration copied to IntelliJ successfully!
  Target: /home/user/.config/github-copilot/intellij/mcp.json
```

#### `make mcp-copy-vscode`
Copy `mcp.json` from project root to VSCode Copilot configuration directory.

**Usage:**
```bash
make mcp-copy-vscode
```

#### `make mcp-copy-all`
Copy `mcp.json` to all supported IDEs (IntelliJ + VSCode).

**Usage:**
```bash
make mcp-copy-all
```

---

### 🔄 Sync Commands

#### `make mcp-sync`
Sync `mcp.json` from IntelliJ back to project root.

**Use case:** When you've modified the configuration in IntelliJ and want to bring changes back to the project.

**Usage:**
```bash
make mcp-sync
```

---

### 🔍 Inspection Commands

#### `make mcp-show`
Display the current MCP configuration from project root.

**Features:**
- Pretty-prints JSON if `jq` is installed
- Falls back to plain `cat` if `jq` is not available

**Usage:**
```bash
make mcp-show
```

**Example output:**
```json
{
    "servers": {
        "laravel-boost": {
            "type": "stdio",
            "command": "php",
            "args": [
                "artisan",
                "mcp:serve"
            ],
            "env": {
                "APP_ENV": "local"
            }
        }
    }
}
```

#### `make mcp-diff`
Compare project and IntelliJ `mcp.json` files.

**Usage:**
```bash
make mcp-diff
```

**Shows:**
- Differences between the two files
- No output if files are identical
- Warnings if either file is missing

---

### ✅ Validation Commands

#### `make mcp-validate`
Validate `mcp.json` syntax.

**What it checks:**
- File exists
- Valid JSON format (requires `jq`)

**Usage:**
```bash
make mcp-validate
```

**Example output:**
```
▶ Validating MCP configuration...
✓ MCP configuration is valid JSON
```

**If `jq` is not installed:**
```
⚠ jq not installed, skipping validation
  Install with: sudo apt install jq
```

---

### ✏️ Edit Commands

#### `make mcp-edit`
Open project `mcp.json` in default editor.

**Usage:**
```bash
make mcp-edit
```

**Opens with:**
- Your `$EDITOR` environment variable
- Falls back to `nano` if not set

---

### 💾 Backup Commands

#### `make mcp-backup`
Create a timestamped backup of IntelliJ `mcp.json`.

**Backup format:**
```
mcp.json.backup.20231211_143025
```

**Usage:**
```bash
make mcp-backup
```

**Example output:**
```
▶ Backing up IntelliJ MCP configuration...
✓ Backup created successfully
```

---

### ❓ Help Commands

#### `make mcp-help`
Display quick reference of all MCP commands.

**Usage:**
```bash
make mcp-help
```

**Output:**
```
MCP Configuration Management Commands:
  make mcp-copy        Copy mcp.json to IntelliJ
  make mcp-copy-vscode Copy mcp.json to VSCode
  make mcp-copy-all    Copy mcp.json to all IDEs
  make mcp-sync        Sync from IntelliJ to project
  make mcp-diff        Compare configurations
  make mcp-edit        Edit project mcp.json
  make mcp-validate    Validate JSON syntax
  make mcp-show        Display configuration
  make mcp-backup      Backup IntelliJ config
```

---

## Current MCP Configuration

The project includes a default `mcp.json` configured for **Laravel Boost MCP Server**:

```json
{
    "servers": {
        "laravel-boost": {
            "type": "stdio",
            "command": "php",
            "args": [
                "artisan",
                "mcp:serve"
            ],
            "env": {
                "APP_ENV": "local"
            }
        }
    }
}
```

### What This Configuration Does

- **Server Name**: `laravel-boost`
- **Type**: `stdio` (Standard Input/Output communication)
- **Command**: Runs `php artisan mcp:serve`
- **Environment**: Sets `APP_ENV` to `local`

This enables GitHub Copilot to communicate with Laravel Boost tools for enhanced Laravel development assistance.

---

## Typical Workflows

### Initial Setup
```bash
# 1. Verify configuration is valid
make mcp-validate

# 2. View current configuration
make mcp-show

# 3. Copy to IntelliJ
make mcp-copy

# OR copy to all IDEs
make mcp-copy-all
```

### After Modifying mcp.json in Project
```bash
# 1. Validate changes
make mcp-validate

# 2. Copy to IDEs
make mcp-copy-all
```

### After Modifying Configuration in IntelliJ
```bash
# 1. Backup current IntelliJ config
make mcp-backup

# 2. Sync changes back to project
make mcp-sync

# 3. Validate
make mcp-validate
```

### Before Major Changes
```bash
# 1. Backup current configuration
make mcp-backup

# 2. Make changes
make mcp-edit

# 3. Validate
make mcp-validate

# 4. Copy to IDEs
make mcp-copy-all
```

### Troubleshooting
```bash
# Compare project vs IDE configuration
make mcp-diff

# View current configuration
make mcp-show

# Validate syntax
make mcp-validate
```

---

## File Locations

### Linux/macOS

| Target | Path |
|--------|------|
| **Project** | `./mcp.json` |
| **IntelliJ** | `~/.config/github-copilot/intellij/mcp.json` |
| **VSCode** | `~/.config/Code/User/globalStorage/github.copilot-chat/mcp.json` |
| **Backup** | `~/.config/github-copilot/intellij/mcp.json.backup.YYYYMMDD_HHMMSS` |

### Variables in Makefile

```makefile
MCP_SOURCE = mcp.json
MCP_INTELLIJ_DIR = $(HOME)/.config/github-copilot/intellij
MCP_INTELLIJ_TARGET = $(MCP_INTELLIJ_DIR)/mcp.json
MCP_VSCODE_DIR = $(HOME)/.config/Code/User/globalStorage/github.copilot-chat
MCP_VSCODE_TARGET = $(MCP_VSCODE_DIR)/mcp.json
```

---

## Dependencies

### Required
- **make** - Already installed (you're using it!)
- **bash** - Standard on Linux/macOS

### Optional but Recommended
- **jq** - For JSON validation and pretty-printing

Install `jq`:
```bash
# Ubuntu/Debian
sudo apt install jq

# macOS
brew install jq

# Fedora
sudo dnf install jq
```

---

## Features

### ✅ What the Commands Handle

- ✅ **Automatic directory creation** - Creates target directories if they don't exist
- ✅ **File validation** - Checks if source file exists before copying
- ✅ **JSON validation** - Validates syntax with `jq` (if installed)
- ✅ **Verbose output** - Shows what's happening at each step
- ✅ **Color-coded messages** - Blue for info, green for success, yellow for warnings
- ✅ **Error handling** - Exits with error if source file is missing
- ✅ **Timestamped backups** - Backup files include date and time
- ✅ **Bidirectional sync** - Copy to IDE or sync back to project
- ✅ **Multi-IDE support** - Works with IntelliJ and VSCode
- ✅ **Diff support** - Compare configurations easily

---

## Customization

### Adding More IDEs

To add support for another IDE, edit the Makefile and add:

```makefile
# Add variable
MCP_MYIDE_DIR = $(HOME)/.config/my-ide/copilot
MCP_MYIDE_TARGET = $(MCP_MYIDE_DIR)/mcp.json

# Add copy command
mcp-copy-myide: ## Copy mcp.json to MyIDE
	@printf "${COLOR_BLUE}▶ Copying MCP configuration to MyIDE...${COLOR_RESET}\n"
	@mkdir -p "$(MCP_MYIDE_DIR)"
	@cp -v "$(MCP_SOURCE)" "$(MCP_MYIDE_TARGET)"
	@printf "${COLOR_GREEN}✓ MCP configuration copied to MyIDE successfully!${COLOR_RESET}\n"

# Update mcp-copy-all
mcp-copy-all: ## Copy mcp.json to all supported IDEs
	@make mcp-copy
	@make mcp-copy-vscode
	@make mcp-copy-myide
```

### Changing Source File Location

If you want to use a different source file:

```makefile
# Change this line in the Makefile
MCP_SOURCE = config/mcp.json
```

---

## Troubleshooting

### "mcp.json not found in project root"
**Cause:** The `mcp.json` file doesn't exist in the project root.

**Solution:**
```bash
# Create the file
touch mcp.json

# Edit it
make mcp-edit

# Or copy from a backup
make mcp-sync
```

### "jq not installed"
**Cause:** JSON validation requires `jq` but it's not installed.

**Solution:**
```bash
sudo apt install jq
```

This is optional - copying still works without `jq`.

### Files are different between project and IDE
**Check differences:**
```bash
make mcp-diff
```

**Sync from IDE to project:**
```bash
make mcp-sync
```

**Or copy from project to IDE:**
```bash
make mcp-copy
```

---

## Integration with Laravel Boost

The MCP configuration is specifically set up for **Laravel Boost**, which provides:

- 🔍 Smart code search across Laravel codebase
- 📚 Access to Laravel documentation
- 🛠️ Artisan command suggestions
- 🧪 Testing utilities
- 📝 Migration helpers
- And more...

**To use Laravel Boost:**

1. Ensure configuration is copied: `make mcp-copy`
2. Restart IntelliJ IDEA
3. GitHub Copilot will now have access to Laravel Boost tools

**Verify it's working:**
```bash
# Run the MCP server manually to test
php artisan mcp:serve
```

---

## Quick Reference Card

| Command | Action |
|---------|--------|
| `make mcp-copy` | Copy to IntelliJ |
| `make mcp-copy-vscode` | Copy to VSCode |
| `make mcp-copy-all` | Copy to all IDEs |
| `make mcp-sync` | Sync from IntelliJ to project |
| `make mcp-diff` | Compare files |
| `make mcp-show` | Display config |
| `make mcp-validate` | Validate JSON |
| `make mcp-edit` | Edit config |
| `make mcp-backup` | Backup IntelliJ config |
| `make mcp-help` | Show help |

---

## Summary

The MCP configuration management system provides:

✅ **Easy synchronization** between project and IDEs
✅ **Multiple IDE support** (IntelliJ, VSCode)
✅ **Safety features** (validation, backups, diffs)
✅ **Developer-friendly** (color output, verbose logging)
✅ **Well-documented** (help command, this guide)

**Get started now:**
```bash
make mcp-copy
```

**Need help?**
```bash
make mcp-help
```

🎉 **Ready to use with Laravel Boost!**

