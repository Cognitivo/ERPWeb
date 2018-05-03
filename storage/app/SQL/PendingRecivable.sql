select

								contact.name as Contact,
								(schedual.debit - schedual.CreditChild) as Balance,
							    schedual.company as Company
								from (
								select
									parent.*,company.name as company,
									( select if(sum(credit) is null, 0, sum(credit))
									from payment_schedual as child where child.parent_id_payment_schedual = parent.id_payment_schedual
									) as CreditChild
								from payment_schedual as parent
                                left join app_company as company
								on company.id_company = parent.id_company
								 where  parent.trans_date between @StartDate and @EndDate
								group by parent.id_payment_schedual
								) as schedual

								inner join contacts as contact on schedual.id_contact = contact.id_contact
								inner join app_currencyfx as fx on schedual.id_currencyfx = fx.id_currencyfx
								inner join app_currency as curr on fx.id_currency = curr.id_currency
								inner join sales_invoice as si on schedual.id_sales_invoice = si.id_sales_invoice
								left join app_contract as contract on si.id_contract = contract.id_contract
								left join app_condition as cond on contract.id_condition = cond.id_condition
								where (schedual.debit - schedual.CreditChild) > 0
								group by schedual.id_payment_schedual
								order by schedual.expire_date
