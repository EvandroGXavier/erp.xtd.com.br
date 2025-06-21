import argparse
from .models import BankAccount
from .repository import AccountRepository


def create_account(args):
    repo = AccountRepository(args.db)
    account = BankAccount(owner=args.owner, balance=args.balance)
    repo.add_account(account)
    print(f"Conta criada com id {account.id}")


def list_accounts(args):
    repo = AccountRepository(args.db)
    for acc in repo.list_accounts():
        print(f"{acc.id} - {acc.owner} - Saldo: {acc.balance}")


def main():
    parser = argparse.ArgumentParser(description="Cadastro de contas bancarias")
    parser.add_argument("--db", default="accounts.json", help="Arquivo de armazenamento")
    sub = parser.add_subparsers(required=True)

    create_p = sub.add_parser("create", help="Criar nova conta")
    create_p.add_argument("owner", help="Titular da conta")
    create_p.add_argument("--balance", type=float, default=0.0, help="Saldo inicial")
    create_p.set_defaults(func=create_account)

    list_p = sub.add_parser("list", help="Listar contas")
    list_p.set_defaults(func=list_accounts)

    args = parser.parse_args()
    args.func(args)


if __name__ == "__main__":
    main()
