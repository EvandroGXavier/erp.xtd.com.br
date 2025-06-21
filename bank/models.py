from dataclasses import dataclass, field
from datetime import datetime
from uuid import uuid4

@dataclass
class BankAccount:
    owner: str
    balance: float = 0.0
    created_at: datetime = field(default_factory=datetime.utcnow)
    id: str = field(default_factory=lambda: str(uuid4()))
