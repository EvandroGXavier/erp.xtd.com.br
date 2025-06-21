from bank.models import BankAccount
from bank.repository import AccountRepository


def test_add_and_list_accounts(tmp_path):
    db = tmp_path / "accounts.json"
    repo = AccountRepository(db)
    acc = BankAccount(owner="Alice", balance=100.0)
    repo.add_account(acc)

    accounts = repo.list_accounts()
    assert len(accounts) == 1
    assert accounts[0].owner == "Alice"
    assert accounts[0].balance == 100.0
