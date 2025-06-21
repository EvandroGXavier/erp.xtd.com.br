import json
from pathlib import Path
from typing import List

from .models import BankAccount

class AccountRepository:
    def __init__(self, path: str | Path = "accounts.json"):
        self.path = Path(path)
        if not self.path.exists():
            self.path.write_text("[]")

    def load_accounts(self) -> List[BankAccount]:
        data = json.loads(self.path.read_text())
        accounts = [BankAccount(**acc) for acc in data]
        return accounts

    def save_accounts(self, accounts: List[BankAccount]) -> None:
        data = [acc.__dict__ for acc in accounts]
        self.path.write_text(json.dumps(data, default=str, indent=2))

    def add_account(self, account: BankAccount) -> None:
        accounts = self.load_accounts()
        accounts.append(account)
        self.save_accounts(accounts)

    def list_accounts(self) -> List[BankAccount]:
        return self.load_accounts()
