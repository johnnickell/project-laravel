# Domain boundary

Fight Common and Fight AccessControl retain their Domain and Application ownership. Laravel-specific adapters and composition remain local; do not redefine shared use cases or reach through public contracts to package internals.

## Test quality and suite balance

Require **100% Unit-only line coverage** of owned unit-testable production behavior. Report the source
denominator, covered/total executable lines, driver and exact justified exclusions; include unexecuted source.
Generated/vendor code and non-behavioral composition may have explicit, justified exclusions. Do not exclude
difficult behavior or simple DTOs to reach the number. Integration/Functional hits cannot fill Unit gaps.
Report branch coverage separately where available. Missing proof or a result below 100% is an unmet requirement,
not a pass. Preserve existing stronger gates; identify missing enforcement and its bounded correction honestly.
This guidance alone does not change the gate or establish a coverage result.

The current denominator is all `app/` source, with no exclusions. The existing exact statement gate uses
combined Integration/Functional coverage; it does not establish Unit-only coverage. Unit attribution and the
required line gate remain to be implemented and qualified. Keep the existing protection while closing that gap.

Test one behavior with clear setup, one execution and preferably one assertion. A few related assertions may
prove one outcome; do not split cohesive checks or hide them in a giant Boolean expression to satisfy a count.
Use the clearest helper: `self::assertSame(20, $total)` for an exact value, `self::assertTrue($allowed)` for a
Boolean. Expected values must come from the contract, not copied production output. Names and whitespace can
show Arrange/Act/Assert or Given/When/Then; redundant phase comments are unnecessary.

Immutable Commands, Events and Queries carry important contracts. Test meaningful assignment, defaults,
validation and transformations; do not discard them because they are small or repeatedly test PHP guarantees.
Look for tautological tests (assertions guaranteed by their own setup), duplicated scenarios and assertions
that would pass after the protected behavior broke. Before removing a test, identify its unique protection
and retain equivalent proof. Remove redundant comments while preserving required docblocks and useful reasons.

Review the suite against roughly **1000 Unit : 100 Integration : 10 Functional** expanded runnable cases,
including data-provider cases; report skipped cases separately. This is a review guide, not a quota or a
coverage ratio. Unit tests isolate behavior without real databases, filesystems, networks or processes;
Integration tests prove real boundaries; Functional tests cover critical journeys and smoke behavior.
Classify by actual behavior, not folder names. Record counts and measured runtime, use the cheapest boundary
that proves the contract, and explain risk-based or small-project exceptions. Never pad Unit counts, relabel
slow tests or delete unique security, concurrency or external-contract protection to meet the ratio.

Do not add tests proving that Deptrac, PHPStan, wrappers, build/planning tools or test infrastructure detect
seeded failures. Validate tooling directly with its owning command. Focused mutation analysis of application
code is allowed: it checks whether assertions detect changed behavior, not whether a quality tool works.
It is optional, not an automatic dependency installation or routine gate. Measure its runtime; surviving
mutants can be equivalent code or missing assertions and are not a test-deletion list.
